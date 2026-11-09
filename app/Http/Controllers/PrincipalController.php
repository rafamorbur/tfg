<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//importamos la clase AEMET (le decimos a LARAVEL donde está la clase)
use App\Services\AemetService; 
//Importamos la clase Muelle
use App\Models\Muelle; 
use App\Models\Reserva;

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
        $muelle = Muelle::with('amarres')->find($id); // Usamos el Muelle importado arriba
        
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
}