<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Backoffice - PortMálaga</title>
    <!-- AÑADIMOS EL JS DEL ADMIN -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin.js'])
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    <!-- Cabecera Superior -->
    <header class="bg-slate-900 text-white p-4 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3">
            <span class="font-bold text-xl">PortMálaga | Backoffice</span>
            <span class="text-slate-300 text-sm ml-4">
                Hola, {{ Auth::user()->nombre }} 
                ({{ Auth::user()->id_rol == 3 ? 'Admin' : 'Empleado' }})
            </span>
        </div>
        <div class="flex gap-4 text-sm font-medium">
            <a href="{{ route('principal') }}" class="hover:text-teal-300 transition">Volver al mapa</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-red-400 hover:text-red-300 transition">Cerrar Sesión</button>
            </form>
        </div>
    </header>

    <!-- Contenedor Principal -->
    <div class="flex h-[calc(100vh-64px)] overflow-hidden">
        
        <!-- Menú Lateral Izquierdo -->
        <aside class="w-64 bg-slate-800 text-white flex flex-col p-4 shrink-0">
            <nav class="space-y-2">
                <!-- BOTONES PARA LA SPA -->
                <button id="btn-menu-reservas" class="w-full text-left px-4 py-2 rounded-lg font-semibold transition bg-teal-600 text-white">
                    Gestión de Reservas
                </button>
                <button id="btn-menu-amarres" class="w-full text-left px-4 py-2 rounded-lg font-semibold transition text-slate-300 hover:bg-slate-700">
                    Control de Amarres
                </button>
                
                @if(Auth::user()->id_rol == 3)
                <button id="btn-menu-usuarios" class="w-full text-left px-4 py-2 rounded-lg font-semibold transition text-slate-300 hover:bg-slate-700">
                    Administración (Usuarios)
                </button>
                @endif
            </nav>
        </aside>

        <!-- Panel Derecho Dinámico -->
        <main class="flex-1 overflow-y-auto p-8 bg-slate-100">
            
            <!-- Mensajes de éxito -->
            @if (session('success'))
                <div class="max-w-6xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                    <p class="font-bold">¡Enhorabuena!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- AQUÍ SE INYECTARÁ EL CONTENIDO -->
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>

        </main>
    </div>
    <x-cookie-banner />
    <x-ayuda-modal />
</body>
</html>