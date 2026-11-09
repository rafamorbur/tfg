<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva; 
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{   
    //****************************************************
    //método mostrar todas las reservas y embarcaciones
    //******************************************************
    public function index()
    {
        // Buscamos las reservas del usuario logueado junto con sus embarcanciones y amarres actuales
        $reservas = Reserva::where('id_usuario', Auth::id())
            ->with(['embarcacion', 'amarre.muelle'])
            ->orderBy('fecha_entrada', 'desc')
            ->get();

        // guardamos las embarcaciones del usuario
        $embarcaciones = Auth::user()->embarcaciones;

        // Le pasamos ambas variables a la vista
        return view('cliente.dashboard', compact('reservas', 'embarcaciones'));

    }

    //****************************************************
    //método para actualizar los datos del usuario
    //******************************************************

        public function updateDatos(Request $request)
    {
        $usuario = Auth::user();

        // Validación (el email debe ser único, excepto el del propio usuario)
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:255|unique:usuario,email,' . $usuario->id_usuario . ',id_usuario',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Actualizamos los datos
        $usuario->update([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('cliente.dashboard')
            ->with('success', 'Datos personales actualizados correctamente.');
    }
     

}