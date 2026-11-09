<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - PortMálaga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center py-10 px-4 font-sans text-slate-800">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-md border border-slate-200 p-8">

        <!-- Título -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-extrabold text-slate-800">Crear cuenta</h1>
            <p class="text-sm text-slate-500 mt-1">Regístrate para poder reservar tu amarre en PortMálaga.</p>
        </div>

        <!-- Errores generales -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <ul class="text-sm text-red-700 list-disc list-inside font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Nombre -->
            <div>
                <x-input-label for="nombre" :value="__('Nombre')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="given-name" />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- Apellidos -->
            <div>
                <x-input-label for="apellidos" :value="__('Apellidos')" />
                <x-text-input id="apellidos" class="block mt-1 w-full" type="text" name="apellidos" :value="old('apellidos')" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
            </div>

            <!-- Tipo de documento -->
            <div>
                <x-input-label for="documento_tipo" :value="__('Tipo de Documento')" />
                <select id="documento_tipo" name="documento_tipo" class="block mt-1 w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm">
                    <option value="DNI" {{ old('documento_tipo') == 'DNI' ? 'selected' : '' }}>DNI</option>
                    <option value="NIE" {{ old('documento_tipo') == 'NIE' ? 'selected' : '' }}>NIE</option>
                    <option value="Pasaporte" {{ old('documento_tipo') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                </select>
                <x-input-error :messages="$errors->get('documento_tipo')" class="mt-2" />
            </div>

            <!-- Número de documento -->
            <div>
                <x-input-label for="numero_documento" :value="__('DNI / NIE / Pasaporte')" />
                <x-text-input id="numero_documento" class="block mt-1 w-full" type="text" name="numero_documento" :value="old('numero_documento')" required />
                <x-input-error :messages="$errors->get('numero_documento')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Teléfono (opcional) -->
            <div>
                <x-input-label for="telefono" :value="__('Teléfono (opcional)')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" autocomplete="tel" />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            <!-- Dirección (opcional) -->
            <div>
                <x-input-label for="direccion" :value="__('Dirección (opcional)')" />
                <x-text-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" :value="old('direccion')" autocomplete="street-address" />
                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div>
                <x-input-label for="contrasena" :value="__('Contraseña')" />
                <x-text-input id="contrasena" class="block mt-1 w-full" type="password" name="contrasena" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('contrasena')" class="mt-2" />
            </div>

            <!-- Confirmar contraseña -->
            <div>
                <x-input-label for="contrasena_confirmation" :value="__('Confirmar contraseña')" />
                <x-text-input id="contrasena_confirmation" class="block mt-1 w-full" type="password" name="contrasena_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('contrasena_confirmation')" class="mt-2" />
            </div>

            <!-- Consentimiento RGPD -->
            <div class="mt-6 space-y-3">
                <!-- Aceptación de la Política de Privacidad -->
                <label class="flex items-start gap-2 cursor-pointer">
                    <input type="checkbox" name="acepto_privacidad" id="acepto_privacidad"
                           class="mt-0.5 w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <span class="text-xs text-slate-600">
                        He leído y acepto la
                        <a href="{{ route('legal.privacidad') }}" target="_blank" class="text-teal-600 underline hover:text-teal-700">
                            Política de Privacidad
                        </a>
                        y el tratamiento de mis datos personales para la gestión de reservas. *
                    </span>
                </label>

                <!-- Consentimiento de edad -->
                <label class="flex items-start gap-2 cursor-pointer">
                    <input type="checkbox" name="mayor_de_edad" id="mayor_de_edad" 
                           class="mt-0.5 w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <span class="text-xs text-slate-600">
                        Declaro ser mayor de 18 años y tener capacidad legal para contratar reservas. *
                    </span>
                </label>
            </div>
            
            <!-- Botones -->
            <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('login') }}" class="text-sm text-slate-600 hover:text-teal-700 underline">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>
                    <a href="{{ route('principal') }}" class="text-sm text-slate-500 hover:text-teal-700 underline">
                        Cancelar y volver al inicio
                    </a>
                </div>

                <button type="submit" class="bg-teal-800 hover:bg-teal-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm text-sm">
                    Registrarse
                </button>
            </div>
        
        </form>
    </div>

</body>
</html>