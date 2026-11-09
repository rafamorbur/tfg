<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Muestra el formulario
    public function index()
    {
        return view('contacto');
    }

    // Procesa el formulario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|min:10|max:1000',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'mensaje.required' => 'El mensaje es obligatorio.',
            'mensaje.min' => 'El mensaje debe tener al menos 10 caracteres.',
        ]);

        //enviamos mensaje de exito
        return back()->with('success', '¡Mensaje enviado! Te responderemos lo antes posible.');
    }
}