<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //Autenticamos el usuario comprando email y contraseña
        $request->authenticate();

        //regeneramos la sesión
        $request->session()->regenerate();

        // Lógica de redirección por roles
        $user = Auth::user();

        if ($user->id_rol == 1) {
            // Para el caso del rol 1 cliente
            return redirect()->intended(route('principal', absolute: false));
        } elseif ($user->id_rol == 2 || $user->id_rol == 3) {
            // Para el caso del rol 2 y 3 empleado y administrador
            return redirect()->intended(route('admin.backoffice', absolute: false));
        }

        //Por defecto para cuando no exista rol
        return redirect()->intended(route('dashboard', absolute: false));
    }

    // Eliminamos la sesíón de forma segura
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
