<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Cliente - PortMálaga</title>
    <!-- Añadimos el archivo cliente.js a Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cliente.js'])
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    <!-- Cabecera Superior -->
    <header class="bg-teal-900 text-white p-4 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3">
            <span class="font-bold text-xl">PortMálaga</span>
            <span class="text-teal-200 text-sm ml-4">Hola, {{ Auth::user()->nombre }}</span>
        </div>
        <div class="flex gap-4 text-sm font-medium">
            <a href="{{ route('principal') }}" class="hover:text-teal-200 transition">Volver al mapa</a>
            <a href="#" class="hover:text-teal-200 transition">Mi Cuenta</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-red-300 hover:text-red-100 transition">Cerrar Sesión</button>
            </form>
        </div>
    </header>

    <!-- Contenedor Principal -->
    <div class="flex h-[calc(100vh-64px)] overflow-hidden">
        
        <!-- Menú Lateral Izquierdo -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col p-4 shrink-0">
            <nav class="space-y-2">
                <!-- Usamos IDs en los botones -->
                <button id="btn-menu-reservas" class="w-full text-left px-4 py-2 rounded-lg font-semibold transition bg-teal-50 text-teal-800">
                    Mis Reservas
                </button>
                <button id="btn-menu-barcos" class="w-full text-left px-4 py-2 rounded-lg font-semibold transition text-slate-600 hover:bg-slate-50">
                    Mis Embarcaciones
                </button>
                <button id="btn-menu-datos" class="w-full text-left px-4 py-2 rounded-lg font-semibold transition text-slate-600 hover:bg-slate-50">
                    Mis Datos
                </button>
            </nav>
        </aside>

        <!-- Panel Derecho Dinámico -->
        <main class="flex-1 overflow-y-auto p-8 bg-slate-50">
            
            <!-- Mensajes de éxito globales (sirven para cualquier página del panel) -->
            @if (session('success'))
                <div class="max-w-4xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                    <p class="font-bold">¡Enhorabuena!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- aqui inyectamos el contenido de las 3 vistas: datos personales, reservas, embarcaciones-->
            <div class="max-w-4xl mx-auto">
                @yield('content')
            </div>

        </main>
    </div>
    <x-cookie-banner />
    <x-ayuda-modal />
</body>
</html>