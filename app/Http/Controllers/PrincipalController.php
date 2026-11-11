<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//importamos la clase AEMET (le decimos a LARAVEL donde está la clase)
use App\Services\AemetService; 
//Importamos la clase Muelle
use App\Models\Muelle; 
use App\Models\Reserva;
use App\Models\Amarre;

class PrincipalController extends Controller
{
    //Inyectamos el servicio como parámetro (inyección de dependencias)
    public function index(AemetService $aemet)
    {
        //Llamamos al método para obtener el tiempo
        $tiempo = $aemet->getPrediccion();

        // Buscamos todos los muelles en la base de datos y sus amarres
        $muelles = Muelle::with('amarres')->get(); 
        
        $hoy = date('Y-m-d');

        //Calculamos el estado visual en tiempo real para todos los amarres
        foreach ($muelles as $muelle) {
            foreach ($muelle->amarres as $amarre) {
                if ($amarre->estado === 'mantenimiento') {
                    $amarre->estado_visual = 'mantenimiento';
                } else {
                    $ocupadoHoy = Reserva::where('id_amarre', $amarre->id_amarre)
                        ->whereIn('estado', ['confirmada', 'pendiente'])
                        ->where('fecha_entrada', '<=', $hoy)
                        ->where('fecha_salida', '>=', $hoy)
                        ->exists();

                    $amarre->estado_visual = $ocupadoHoy ? 'ocupado' : 'disponible';
                }
            }
        }
        
        // Devolvemos la vista principal pasándole la variable $tiempo y la variable $muelles
        return view('principal', compact('tiempo', 'muelles'));
    }


    public function obtenerTiempoApi($codigo, AemetService $aemet)
    {
        // Pedimos a AEMET el tiempo del código de municipio que nos llega
        $tiempo = $aemet->getPrediccion($codigo);
        
        // Devolvemos el array como JSON para que JavaScript lo lea
        return response()->json($tiempo);
    }

    public function obtenerDetallesMuelle($id)
    {   
        //además de obtener los muelles obtenemos sus amarres y los servicios
        $muelle = Muelle::with(['amarres', 'servicios'])->find($id);  
        
        if (!$muelle) {
            return response()->json(['error' => 'Muelle no encontrado'], 404);
        }

        $hoy = date('Y-m-d');

        // Recorremos los amarres para calcular su estado visual en tiempo real
        foreach ($muelle->amarres as $amarre) {
            // Si está en mantenimiento físico, ese estado manda
            if ($amarre->estado === 'mantenimiento') {
                $amarre->estado_visual = 'mantenimiento';
            } else {
                // Comprobamos si tiene alguna reserva activa HOY
                $ocupadoHoy = Reserva::where('id_amarre', $amarre->id_amarre)
                    ->whereIn('estado', ['confirmada', 'pendiente'])
                    ->where('fecha_entrada', '<=', $hoy)
                    ->where('fecha_salida', '>=', $hoy)
                    ->exists();

                $amarre->estado_visual = $ocupadoHoy ? 'ocupado' : 'disponible';
            }
        }

        return response()->json($muelle);
    }

    //Método para filtrar amarres
        public function filtrarAmarres(Request $request)
    {   
        //recogemos todos los datos del filtro psados a través de la URL
        $eslora = $request->query('eslora', 0);
        $manga = $request->query('manga', 0);
        $calado = $request->query('calado', 0);
        $fechaEntrada = $request->query('fecha_entrada');
        $fechaSalida = $request->query('fecha_salida');

        // Realizamos un primer filtro de amarres
        // buscamos aquellos amarres que estén activos y no en mantenimiento
        //nos traemos todas las reservas presentes y futuras
        $consultaAmarres = Amarre::where('estado', '!=', 'mantenimiento')
            ->where('activo', true);

        //filtramos por las dimensiones
        //si es mayor que cero entendemos que el usuario ha indicado unas dimensiones concretas
        //el filtro puede ser para 0,1,2 o las 3 dimensiones
        //filtramos de manera acumulativa
        if ($eslora > 0) $consultaAmarres->where('eslora_max', '>=', $eslora);
        if ($manga > 0) $consultaAmarres->where('manga_max', '>=', $manga);
        if ($calado > 0) $consultaAmarres->where('calado_max', '>=', $calado);

        // comprobamos si ha filtrado por fecha (en caso contrario por dimensiones)
        //si ha filtrado por 1 fecha o por ninguna se salta todo el bloque
        if ($fechaEntrada && $fechaSalida) {
            // buscamos las reservas activas
            $amarresOcupados = Reserva::whereIn('estado', ['pendiente', 'confirmada'])
                //buscamos aquellas reservas que empiecen antes o el mismo dia de la fecha de salida
                ->where('fecha_entrada', '<=', $fechaSalida)
                //buscamos aquellas reservas que terminen antes o el mismo dia de fecha etnrada
                ->where('fecha_salida', '>=', $fechaEntrada)
                // solo nos quedamos con las reservas que coinciden con las fehcas del usuario
                //de estas reservas solo queremos el id del amarre
                ->pluck('id_amarre') 
                //y lo convertimos en un array
                //si un id está en esta lista significa que está reserva para el periodo que desea el usuario
                ->toArray();          

            // volvemos a la consulta de todos los amarres
            //y le decimos que nos devuelva aquellos ids que no forman parte del array
            $consultaAmarres->whereNotIn('id_amarre', $amarresOcupados);
        }

        // ejecutamos y guardamos los amarres ocupados y que cumplen todas las condiciones
        $amarresEncontrados = $consultaAmarres->get();
        
        //a partir de los amarres compatibles buscamos a que puertos o muelle pertenecen
        $muellesCompatibles = $amarresEncontrados->pluck('id_muelle')
            ->unique() // con uqe salga una vez nos vale
            ->values()// solo nos interesa saber que muelle tiene hueco
            ->toArray();// lo convertimos en un array

        // empaquetamos toda la información y se la pasamos a js
        return response()->json([
            'total_muelles_compatibles' => count($muellesCompatibles),//contamos el numero de muelles que tienen un hueco libre
            'muelles_compatibles' => $muellesCompatibles //le pasamos el array
        ]);
    }
}