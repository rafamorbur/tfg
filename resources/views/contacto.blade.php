<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto - PortMálaga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans">
    <main class="flex-1 max-w-2xl mx-auto p-8 bg-white shadow-md my-8 rounded-lg w-full">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Contacto</h1>
        <p class="text-slate-500 mb-6">¿Tienes alguna duda o sugerencia? Escríbenos.</p>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                <p class="font-bold">¡Enhorabuena!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('contacto.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('nombre') border-red-500 @enderror">
                @error('nombre') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('email') border-red-500 @enderror">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Mensaje</label>
                <textarea name="mensaje" rows="5" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('mensaje') border-red-500 @enderror">{{ old('mensaje') }}</textarea>
                @error('mensaje') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="pt-2">
                <button type="submit" class="bg-teal-800 text-white font-semibold py-2 px-6 rounded-lg hover:bg-teal-700 transition shadow-md">
                    Enviar Mensaje
                </button>
            </div>
        </form>

        <div class="mt-8 pt-4 border-t">
            <a href="{{ route('principal') }}" class="text-teal-600 hover:underline font-semibold">&larr; Volver al inicio</a>
        </div>
    </main>
    <x-footer />
</body>
</html>