<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amarre;
use App\Models\Embarcacion; 
use App\Models\Servicio;
use App\Models\Reserva;    
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;          
use Illuminate\Support\Str; 

class ReservaController extends Controller
{   
    //Función para mostrar el formulario de reserva
    //la funcion recibe el parámetro id_amarre directamente de la url
    public function create($id_amarre)
    {
        // Si no se ha logueado redirigimos al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Buscamos el amarre y el muelle
        $amarre = Amarre::with('muelle')->findOrFail($id_amarre);

        // Obtenemos las embarcaciones del usuario logueado
        $usuario = Auth::user();
        $embarcaciones = $usuario->embarcaciones;

        //Obtenemos todos los servicios disponibles
        $servicios = Servicio::where('activo', true)->get();

        //cuando devuelve la vista dentro del formulario hay un campo oculto
        //<input type="hidden" name="id_amarre" value="{{ $amarre->id_amarre }}">
        //en la vista muestra el amarre, todas als embarcaciones del usuaruo y todos los servicios del muelle
        return view('reserva.create', compact('amarre', 'embarcaciones', 'servicios'));
    }

        //Creamos una función para guardar una nueva reserva en la BD
        //Usamos la clase Request para recibir los datos enviados por el formulario (además de cabeceras, cookies, archivos)
        public function store(Request $request)
    {
        // Con Validator::make revisamos que las reglas se cumplen sin lanzar excepción
        //si todo funciona el codigo continua
        //si falla algo guardamos los errores en el array
        //y redirigimos al usuario al formulario con todos los errores
        $validator = Validator::make($request->all(), [
            'id_amarre' => 'required|exists:amarre,id_amarre',
            'id_embarcacion' => 'required|exists:embarcacion,id_embarcacion',
            'fecha_entrada' => 'required|date|after_or_equal:today',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicio,id_servicio',
            'acepto_terminos' => 'required|accepted',
        ], [
            // En el caso de que un campo no se cumpla lanzamos un mensaje de error (clave = 'campo.regla')
            'fecha_entrada.required' => 'Debes indicar la fecha de entrada.',
            'fecha_entrada.after_or_equal' => 'La fecha de entrada no puede ser anterior a hoy.',
            'fecha_salida.required' => 'Debes indicar la fecha de salida.',
            'fecha_salida.after' => 'La fecha de salida debe ser posterior a la fecha de entrada.',
            'id_embarcacion.required' => 'Por favor, selecciona una embarcación.',
            'id_embarcacion.exists' => 'La embarcación seleccionada no es válida.',
            'acepto_terminos.required' => 'Debes aceptar los Términos y Condiciones y la Política de Reembolsos.',
            'acepto_terminos.accepted' => 'Debes aceptar los Términos y Condiciones y la Política de Reembolsos.',
        ]);


        $errores = []; // Array para acumular todos los errores
        //si existen errores los mostramos
        if ($validator->fails()) {
            $errores = $validator->errors()->all();
        }
    
        // BUSCAMOS EL AMARRE Y LA EMBARCACIÓN
        //el id del amarre está impreso dentro <option value="{{ $barco->id_embarcacion }}">
        //con findorFail devolvemos el amarre o soltamos un null
        // (Solo buscamos si los IDs básicos son válidos para evitar errores)
        //como la ejecucion no se detiene cuando encuentra un error usamos filled: si el valor es nulo
        //busques en la BD
        if ($request->filled('id_amarre') && $request->filled('id_embarcacion') && !$validator->errors()->has('id_amarre') && !$validator->errors()->has('id_embarcacion')) {
            
            $amarre = Amarre::findOrFail($request->id_amarre);
            $embarcacion = Embarcacion::findOrFail($request->id_embarcacion);

            //Comprobar que el barco pertenece al usuario logueado
            $usuario = Auth::user();
            if (!$usuario->embarcaciones->contains($embarcacion->id_embarcacion)) {
                $errores[] = 'La embarcación seleccionada no te pertenece.';
            }

            // comprobamos que la embarcación cabe en el amarre
            // Forzamos a float porque PostgreSQL devuelve los decimales como strings
            if ((float)$embarcacion->eslora > (float)$amarre->eslora_max || 
                (float)$embarcacion->manga > (float)$amarre->manga_max || 
                (float)$embarcacion->calado > (float)$amarre->calado_max) {
                //en caso de que exista errores se devuelve al cliente a la misma página del formulario    
                //y gudarda temporalmente los errores para mostrarlos al usuario 
                $errores[] = 'Las dimensiones del amarre no coinciden con las de tu embarcación';
            }

            // comprobamos su el amarre está libre en las fechas solicitadas
            // Buscamos si hay alguna reserva que se cruce con las fechas solicitadas
            // (Solo comprobamos si las fechas básicas son válidas)
            if ($request->filled('fecha_entrada') && $request->filled('fecha_salida') && !$validator->errors()->has('fecha_entrada') && !$validator->errors()->has('fecha_salida')) {
                
                // Buscamos todas las reservas del amarre
                $esReserva = Reserva::where('id_amarre', $amarre->id_amarre)
                    //las que sean pendiente o confimadas
                    ->whereIn('estado', ['pendiente', 'confirmada'])
                    //aquellas cuya fecha de entrada sea anterior o igual a la fecha de salida del usuario
                    ->where('fecha_entrada', '<=', $request->fecha_salida)
                    //aquelals cuya fecha de salida sea posterior o igual a la fecha de salida del usuario
                    ->where('fecha_salida', '>=', $request->fecha_entrada)
                    //si existe. 
                    ->exists();
                //Si existe alguna reserva que cumpla con las limitaciones impuestas
                if ($esReserva) {
                    $errores[] = 'El amarre ya está ocupado en esas fechas.';
                }
            }
        }

        // Si hay algún error acumulado (de validación o de lógica), volvemos al formulario
        if (count($errores) > 0) {
            return back()->withErrors($errores)->withInput();
        }

        //Calculamos los dias
        //para ello usamos la libreria Carbom de laravel que convierte un string en una fecha
        $fechaEntrada = Carbon::parse($request->fecha_entrada);
        $fechaSalida = Carbon::parse($request->fecha_salida);
        //Calculamos la diferencia de dias
        $dias = $fechaEntrada->diffInDays($fechaSalida);
        
        // Si la fecha de entrada y de salida es el mismo dia contamos 1
        if ($dias == 0) $dias = 1; 

        //calculamos el precio entre los dias y la tarifa_base
        $precioTotal = $dias * $amarre->tarifa_base;

        // Procedemos a crear una nueva reserva en la BD
        $nuevaReserva = Reserva::create([
            // Generamos un código único aleatorio (Ej: RES-65A3B)
            'codigo_reserva' => 'RES-' . strtoupper(Str::random(5)),
            'id_usuario' => Auth::id(),
            'id_embarcacion' => $embarcacion->id_embarcacion,
            'id_amarre' => $amarre->id_amarre,
            'fecha_entrada' => $request->fecha_entrada,
            'fecha_salida' => $request->fecha_salida,
            'estado' => 'pendiente',
            'precio_total' => $precioTotal,
        ]);

        // Si hay servicios contratados los guardamos
        //Comprobamos si hay servicios
        //laravel guarda los srevicios como un array;  $request->servicios = [1, 3];

        if ($request->has('servicios')) {
            foreach ($request->servicios as $id_servicio) {
                $servicio = Servicio::find($id_servicio);
                if (!$servicio) continue;

                $esFijo = str_contains(strtolower($servicio->unidad_cobro ?? ''), 'servicio') || str_contains(strtolower($servicio->unidad_cobro ?? ''), 'estancia');
                $multiplicador = $esFijo ? 1 : $dias;
                $subtotalServicio = $servicio->precio_base * $multiplicador;

                // Guardamos en la tabla intermedia reserva_servicio
                $nuevaReserva->servicios()->attach($id_servicio, [
                    'cantidad' => $multiplicador, 
                    'precio_unitario' => $servicio->precio_base,
                    'subtotal' => $subtotalServicio,
                    'fecha_contratacion' => now()
                ]);

                // Por cada vuelta de bucle sumamos el precio del servicio al total
                $precioTotal += $subtotalServicio;
            }

            // Actualizamos el precio total de la reserva con los servicios incluidos
            $nuevaReserva->update(['precio_total' => $precioTotal]);
        }

        // Una vez realizada la reserva redirigimos al cliente a su zona privada
        return redirect()->route('cliente.dashboard')
        //le mostramos un mensaje de éxito con el código alteatorio
            ->with('success', "¡Reserva creada con éxito! Tu código de reserva es: {$nuevaReserva->codigo_reserva}. Estado: Pendiente de aprobación.");
    }

         //***********************************
     //  función para cancelar una reserva
     //************************************
    public function cancelarReserva($id)
    {
        //Buscamos la reserva por su ID
        $reserva = Reserva::findOrFail($id);

        // comprobamos que la reserva sea del usuario
        if ($reserva->id_usuario !== Auth::id()) {
            return back()->withErrors(['error' => 'No tienes permiso para cancelar esta reserva.']);
        }

        // Inicialmente solo se pueden cancelar las pendientes
        if ($reserva->estado !== 'pendiente') {
            return back()->withErrors(['error' => 'Solo puedes cancelar reservas en estado pendiente.']);
        }
        
        // Actualizamos el estado a cancelada
        $reserva->update(['estado' => 'cancelada']);

        // redirigimos con mensaje de éxito
        return redirect()->route('cliente.dashboard')
            ->with('success', 'La reserva ' . $reserva->codigo_reserva . ' ha sido cancelada correctamente.');
    }

}