<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Añadimos los campos requeridos en el registro a la validación
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:150'],
            'documento_tipo' => ['required', 'string', 'in:DNI,NIE,Pasaporte'],
            'numero_documento' => ['required', 'string', 'max:30', 'unique:usuario,numero_documento'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuario,email'],
            'contrasena' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:255'],
            // Consentimiento RGPD: aceptación explícita de la Política de Privacidad
            'acepto_privacidad' => ['accepted'],
            // Declaración de mayoría de edad: capacidad legal para contratar reservas
            'mayor_de_edad' => ['accepted'],
        ], [
            // Mensajes personalizados para la política de privacidad y ser mayor de 18 años
            'acepto_privacidad.accepted' => 'Debes aceptar la Política de Privacidad para registrarte.',
            'mayor_de_edad.accepted' => 'Debes declarar que eres mayor de 18 años para poder reservar.',
        ]);


        // Una vez validados creamos el usuario con todos los datos
        $user = User::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'documento_tipo' => $request->documento_tipo,
            'numero_documento' => $request->numero_documento,
            'email' => $request->email,
            'password' => Hash::make($request->contrasena),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'id_rol' => 1,
            'activo' => true,
        ]);

        //disparamos el evento del registro
        event(new Registered($user));

        //logueamos el usuario
        Auth::login($user);

        //lo redirigimos a la vista dashboard    
        return redirect(route('cliente.dashboard', absolute: false));
    }
}