<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortMálaga Management</title>

    <!-- Cargamos Tailwind y Vite. 
         Gracias a la directiva de Vite compilamos los archivos css y js 
         y creamos las etiquetas link y script. -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!--Enlace para cargar los estilos propios del mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>

<!--Cargamos los estilos para el BODY
que ocupe toda la pantalla, que el contenedro sea flexible, sin scroll -->

<body class="h-screen flex flex-col bg-slate-50 overflow-hidden font-sans">

    <!--Estilos contendor CABECERA
    Contenedor flexible, empujamos los elemenos a los lados dejando el centro vacio
    lo alineamos al centro verticalmente
    Nos aseguramos que el contenedor este por encima del mapa-->
    <header class="h-16 bg-white border-b flex items-center justify-between px-6 shrink-0 shadow-sm z-10">
        <!-- Contenedor izquierdo: LOGO 
         Alienados y en el centro-->
        <div class="flex items-center gap-3">
            <!-- Para el logotipo usamos un gráfico vectorial   -->
            <div class="bg-teal-900 text-white p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M12 3v18M7.5 7.5l9 9M7.5 16.5l9-9"></path>
                </svg>
            </div>
            <!--Colocamos los 2 titulos uno encima del otro -->
            <div class="flex flex-col">
                <span class="font-bold text-lg leading-tight text-slate-800">PortMálaga</span>
                <span class="text-xs text-slate-500">Gestión de amarres</span>
            </div>
        </div>

        <!-- Contendor derecho: Clima (aemet) y Sesión
        Los elementos se colocan uno al lado del otro 
        -->
        <div class="flex items-center gap-6">
            <!-- Widget AEMET -->
            @if($tiempo)
            @php
                $estado = mb_strtolower($tiempo['estado'] ?? '');
                $icono = '🌤️';
                if (str_contains($estado, 'lluvia') || str_contains($estado, 'chubasco') || str_contains($estado, 'llovizna')) {
                    $icono = '🌧️';
                } elseif (str_contains($estado, 'tormenta')) {
                    $icono = '⛈️';
                } elseif (str_contains($estado, 'nuboso') || str_contains($estado, 'nubes') || str_contains($estado, 'cubierto')) {
                    $icono = '☁️';
                } elseif (str_contains($estado, 'despejado') || str_contains($estado, 'soleado')) {
                    $icono = '☀️';
                } elseif (str_contains($estado, 'niebla') || str_contains($estado, 'bruma')) {
                    $icono = '🌫️';
                } elseif (str_contains($estado, 'nieve')) {
                    $icono = '❄️';
                }
            @endphp

            <div class="hidden md:flex items-center gap-3 border border-slate-200 rounded-full px-4 py-1.5 text-sm text-slate-600 bg-white cursor-help"
                title="Estado: {{ $tiempo['estado'] }} | Racha máx: {{ $tiempo['racha_max'] }} km/h | Humedad: {{ $tiempo['humedad_max'] }}% | Sensación térmica: {{ $tiempo['sens_termica'] }}°C">
                
                <!-- Temperaturas -->
                <div class="flex items-center gap-1 font-semibold text-slate-800">
                    <span>{{ $icono }}</span>
                    <span>{{ $tiempo['temp_max'] }}° / {{ $tiempo['temp_min'] }}°C</span>
                </div>
                
                <div class="w-px h-4 bg-slate-300"></div>
                
                <!-- Viento y dirección -->
                <div class="flex items-center gap-1">
                    <span>💨</span>
                    <span>{{ $tiempo['viento'] }} km/h ({{ $tiempo['direccion_viento'] }})</span>
                </div>

                <div class="w-px h-4 bg-slate-300"></div>

                <!-- Probabilidad de lluvia -->
                <div class="flex items-center gap-1">
                    <span>🌧️</span>
                    <span>{{ $tiempo['prob_lluvia'] }}%</span>
                </div>

                <span class="text-xs font-bold text-slate-400 ml-1">AEMET</span>
            </div>
            @else
                <!-- Si la API falla (devuelve null), mostramos este mensaje de fallback -->
                <div class="hidden md:flex items-center gap-2 border border-red-200 bg-red-50 rounded-full px-4 py-1.5 text-sm text-red-600">
                    <span>⚠️ Tiempo no disponible</span>
                </div>
            @endif

            <!--Contenedor LOGUIN y REGISTRO -->
            <div class="flex items-center gap-4">
                <!--Cuando es invitado o no se ha logueado
                usamos la directiva guest de blade-->
                @guest
                <!--Botón login-->
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-teal-600 transition">Iniciar Sesión</a>
                <!--Botón registro-->
                <a href="{{ route('register') }}" class="text-sm font-medium bg-teal-800 text-white px-4 py-2 rounded-md hover:bg-teal-700 transition shadow-sm">Registrarse</a>
                <!--Cuando inicia sesión
                Si no se cumple lo anterior se ejecuta lo siguiente -->
                @else
                <div class="flex items-center gap-3 border-r border-slate-200 pr-4">
                    <!--Extraemos las 2 primeras letras del usuario-->
                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-sm">
                        {{ substr(Auth::user()->nombre, 0, 1) }}
                    </div>
                    <!--Damos la bienvenida al usuario-->
                    <div class="text-sm">
                        <span class="text-slate-500">Bienvenido, </span>
                        <span class="font-semibold text-slate-800">{{ Auth::user()->nombre }}</span>
                    </div>
                </div>
                <!--comprobamos el rol del usuario para llevarlo a su zona privada correspondiente-->
                @if(Auth::user()->id_rol == 1)
                <a href="{{ route('cliente.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-teal-600 flex items-center gap-1 transition">Mi Cuenta</a>
                @else
                <a href="{{ route('admin.backoffice') }}" class="text-sm font-medium text-slate-600 hover:text-teal-600 flex items-center gap-1 transition">Backoffice</a>
                @endif
                <!--cerramos la sesión mediante un formulario-->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 flex items-center gap-1 transition">Cerrar Sesión</button>
                </form>
                @endguest
            </div>
        </div>
    </header>

    <!--Estilos CONTENEDOR CENTRAL: se divide en 3 partes -->

    <main class="flex flex-1 overflow-hidden">

        <!-- Columna Izquierda: filtros de búsqueda -->
        <aside class="w-80 bg-white border-r p-5 overflow-y-auto hidden md:flex flex-col shrink-0 h-full">
            
            <!-- Cabecera del panel de filtros -->
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="bg-slate-100 p-2 rounded-lg text-slate-600">
                    <!-- Icono de filtro SVG -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 leading-tight">Buscar amarre</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Encuentra el espacio ideal</p>
                </div>
            </div>

            <!-- Formulario de filtros -->
            <div class="space-y-4">
                <!-- Fechas -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Fecha de entrada</label>
                    <div class="relative">
                        <input type="date" id="filtro-fecha-entrada" min="{{ date('Y-m-d') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm py-2 px-3 text-slate-700">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Fecha de salida</label>
                    <div class="relative">
                        <input type="date" id="filtro-fecha-salida" min="{{ date('Y-m-d') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm py-2 px-3 text-slate-700">
                    </div>
                </div>

                <!-- Dimensiones (Grid de 3 columnas) -->
                <div class="grid grid-cols-3 gap-2.5 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Eslora</label>
                        <div class="relative">
                            <input type="number" id="filtro-eslora" placeholder="12" step="0.1" min="0" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm py-2 pl-2.5 pr-6 text-slate-700">
                            <span class="absolute right-2 top-2 text-xs text-slate-400">m</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Manga</label>
                        <div class="relative">
                            <input type="number" id="filtro-manga" placeholder="4.2" step="0.1" min="0" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm py-2 pl-2.5 pr-6 text-slate-700">
                            <span class="absolute right-2 top-2 text-xs text-slate-400">m</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Calado</label>
                        <div class="relative">
                            <input type="number" id="filtro-calado" placeholder="1.8" step="0.1" min="0" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm py-2 pl-2.5 pr-6 text-slate-700">
                            <span class="absolute right-2 top-2 text-xs text-slate-400">m</span>
                        </div>
                    </div>
                </div>

                <!-- Caja de errores de validación -->
                <div id="filtro-errores" class="hidden bg-red-50 border border-red-200 text-red-600 rounded-xl p-3 text-xs">
                    <ul id="lista-errores" class="list-disc list-inside space-y-1"></ul>
                </div>
            </div>

            <!-- El "flex-1" empuja el contenido de abajo hacia el final del panel -->
            <div class="flex-1"></div>

            <!-- Zona inferior: Aviso y Botones -->
            <div class="pt-4 space-y-3 mt-auto">
                <!-- Cuadro informativo -->
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-start gap-2.5">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></div>
                    <p id="texto-resultados" class="text-xs text-slate-700 leading-tight font-medium">
                        5 de 5 muelles con amarres compatibles
                    </p>
                </div>

                <!-- Botón Aplicar -->
                <button type="button" id="btn-aplicar-filtros" class="w-full bg-teal-800 text-white font-medium py-2.5 rounded-lg hover:bg-teal-700 transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Aplicar filtros
                </button>

                <!-- Botón Limpiar -->
                <button type="button" id="btn-limpiar-filtros" class="w-full bg-white border border-slate-300 text-slate-700 font-medium py-2.5 rounded-lg hover:bg-slate-50 transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Limpiar
                </button>
            </div>
        </aside>

        <!-- Columna central: sirve para mostrar el mapa -->
        <section class="flex-1 relative bg-slate-200">
            <div id="map" class="w-full h-full z-0"></div>
            <!-- Controles y tarjetas flotantes estilo Navily / v0 (Sobre el mapa) -->
            <div class="absolute top-4 right-4 z-[400] flex items-center gap-2">
                <div class="bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-xl p-1 shadow-lg flex text-xs font-semibold">
                    <button id="btn-capa-calles" type="button" class="px-3 py-1.5 rounded-lg bg-teal-800 text-white transition">Mapa</button>
                    <button id="btn-capa-satelite" type="button" class="px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition">Satélite</button>
                </div>
                <div id="badge-coordenadas" class="hidden md:flex bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-xl px-3 py-1.5 shadow-lg items-center gap-1.5 text-xs font-semibold text-slate-700">
                    <span class="text-teal-700">🧭</span>
                    <span id="mapa-coordenadas-texto">36°43' N 4°25' O</span>
                </div>
            </div>
            <div id="card-puerto-mapa" class="hidden absolute top-4 left-4 z-[400] bg-white/95 backdrop-blur-md border border-slate-200/80 rounded-2xl p-4 shadow-xl max-w-xs transition-all">
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-teal-800 uppercase tracking-wider mb-1">
                    <span>🌊 Costa del Sol</span>
                </div>
                <h3 id="mapa-puerto-nombre" class="font-extrabold text-slate-800 text-base leading-tight mb-0.5">Puerto</h3>
                <p id="mapa-puerto-ubicacion" class="text-xs text-slate-500">Málaga, Andalucía</p>
            </div>
            <button id="btn-volver-mapa" type="button" class="hidden absolute bottom-6 left-6 z-[400] bg-white/95 backdrop-blur-md hover:bg-white text-slate-800 px-4 py-2.5 rounded-xl shadow-xl border border-slate-200 text-xs font-bold flex items-center gap-2 transition hover:scale-105">
                <span>←</span> Volver a la costa
            </button>
        </section>

        <!-- Columna derecha: mostramos los datos asíncronos de cada muelle -->
        <aside class="w-96 bg-white border-l p-4 overflow-y-auto hidden lg:block shrink-0">
            <!-- Contenedor del panel tipo parking -->
            <div id="panel-detalles">
                <!-- Aquí aparecerá el panel de todos los muelles generado por JS -->
            </div>
        </aside>

    </main>

    <!-- Script para el mapa: Usamos la libreria Leaflet para que el mapa sea
      interactivo 
    -->
    <!--descargamos el motor de Leaflet desde internet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Pasamos los datos de PHP a JavaScript de forma segura -->
    <script>
        window.muellesData = @json($muelles);
    </script>

    <!-- Cargamos nuestro script de JavaScript a través de Vite -->
    @vite('resources/js/principal.js')

     <x-footer />
     <x-cookie-banner />
    <x-ayuda-modal />

</body>
</html>