<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Amarre - PortMálaga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/reserva.js'])
</head>
<body class="bg-slate-50 min-h-screen py-10 px-4 font-sans text-slate-800">

    <!-- Barra superior con botón volver y migas de pan -->
    <div class="max-w-6xl mx-auto mb-6 flex justify-between items-center">
        <a href="{{ route('principal') }}" class="text-teal-700 hover:text-teal-900 font-medium text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al mapa
        </a>
        <div class="hidden sm:flex items-center gap-2 text-xs">
            <span class="text-teal-600 font-semibold flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                Amarre seleccionado
            </span>
            <span class="text-slate-300">/</span>
            <span class="text-slate-700 font-bold">Datos de la reserva</span>
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        <!-- Título y subtítulo del formulario -->
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mb-1">Formulario de Reserva</h1>
        <p class="text-slate-500 text-sm mb-8">Tu amarre está a un paso. Revisa tu estancia y personaliza tu llegada.</p>

        <!-- Mostrar errores de validación del backend si los hay -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-xl shadow-sm">
                <ul class="text-sm text-red-700 list-disc list-inside font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reserva.store') }}" method="POST" id="formulario-reserva" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf
            <input type="hidden" name="id_amarre" value="{{ $amarre->id_amarre }}">

            <!-- COLUMNA IZQUIERDA: PASOS DEL FORMULARIO -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- PASO 1: FECHAS DE TU ESTANCIA -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="bg-teal-100 text-teal-800 font-bold rounded-full w-6 h-6 flex items-center justify-center text-xs">1</span>
                            <h2 class="text-base sm:text-lg font-bold text-slate-800">Fechas de tu estancia</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-medium">* Campos obligatorios</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Llegada *</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-teal-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                <input type="date" name="fecha_entrada" id="fecha_entrada" required min="{{ date('Y-m-d') }}" value="{{ old('fecha_entrada') }}" 
                                       class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-medium text-slate-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition shadow-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Salida *</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-teal-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                <input type="date" name="fecha_salida" id="fecha_salida" required min="{{ date('Y-m-d') }}" value="{{ old('fecha_salida') }}" 
                                       class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-medium text-slate-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje dinámico de validación de fechas -->
                    <p id="mensaje-fechas" class="hidden text-xs text-teal-700 mt-3 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span id="texto-fechas"></span>
                    </p>
                </div>

                <!-- PASO 2: TU EMBARCACIÓN -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-teal-100 text-teal-800 font-bold rounded-full w-6 h-6 flex items-center justify-center text-xs">2</span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-800">Tu embarcación</h2>
                    </div>

                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Selecciona una embarcación *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-teal-600">
                            <!-- Icono de barco -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </span>
                        <select name="id_embarcacion" id="id_embarcacion" required class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-medium text-slate-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition shadow-sm cursor-pointer">
                            <option value="">-- Elige un barco --</option>
                            @foreach($embarcaciones as $barco)
                                <option value="{{ $barco->id_embarcacion }}" 
                                        data-eslora="{{ (float)$barco->eslora }}" 
                                        data-manga="{{ (float)$barco->manga }}" 
                                        data-calado="{{ (float)$barco->calado }}"
                                        data-nombre="{{ $barco->nombre }}"
                                        {{ old('id_embarcacion') == $barco->id_embarcacion ? 'selected' : '' }}>
                                    {{ $barco->nombre }} {{ $barco->tipo ? '· ' . $barco->tipo : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ficha comparativa de dimensiones vs máximas del amarre -->
                    <div id="box-dimensiones" class="bg-slate-50 border border-slate-100 rounded-xl p-4 mt-4">
                        <div class="grid grid-cols-3 gap-3 text-xs">
                            <div>
                                <span class="text-slate-400 block mb-0.5">Eslora</span>
                                <span class="font-bold text-slate-800 text-sm"><span id="dim-barco-eslora">--</span> m</span>
                                <span class="text-slate-400"> / máx. {{ (float)$amarre->eslora_max }} m</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block mb-0.5">Manga</span>
                                <span class="font-bold text-slate-800 text-sm"><span id="dim-barco-manga">--</span> m</span>
                                <span class="text-slate-400"> / máx. {{ (float)$amarre->manga_max }} m</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block mb-0.5">Calado</span>
                                <span class="font-bold text-slate-800 text-sm"><span id="dim-barco-calado">--</span> m</span>
                                <span class="text-slate-400"> / máx. {{ (float)$amarre->calado_max }} m</span>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje dinámico de compatibilidad -->
                    <p id="mensaje-barco-valido" class="hidden text-xs text-teal-700 font-medium mt-3 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Embarcación compatible: eslora, manga y calado dentro de los límites del amarre.</span>
                    </p>
                    <p id="mensaje-barco-invalido" class="hidden text-xs text-red-600 font-medium mt-3 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span>Embarcación no compatible: supera las dimensiones máximas del amarre.</span>
                    </p>
                </div>

                <!-- PASO 3: SERVICIOS EXTRA -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-teal-100 text-teal-800 font-bold rounded-full w-6 h-6 flex items-center justify-center text-xs">3</span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-800">Servicios extra <span class="text-sm font-normal text-slate-400 ml-1">Opcionales</span></h2>
                    </div>

                    <div class="space-y-3">
                        @foreach($servicios as $servicio)
                            @php
                                $esFijo = str_contains(strtolower($servicio->unidad_cobro ?? ''), 'servicio') || str_contains(strtolower($servicio->unidad_cobro ?? ''), 'estancia');
                                $sufijo = $esFijo ? '/ estancia' : '/ noche';
                            @endphp
                            <label class="flex items-center justify-between p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-teal-500 transition bg-white group">
                                <div class="flex items-center gap-3.5">
                                    <input type="checkbox" name="servicios[]" value="{{ $servicio->id_servicio }}" 
                                           class="servicio-checkbox w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer"
                                           data-precio="{{ $servicio->precio_base }}"
                                           data-nombre="{{ $servicio->nombre }}"
                                           data-tipo="{{ $esFijo ? 'estancia' : 'noche' }}">
                                    <div>
                                        <p class="font-semibold text-slate-800 text-sm group-hover:text-teal-900">{{ $servicio->nombre }}</p>
                                        <p class="text-xs text-slate-500">{{ $servicio->descripcion ?? 'Servicio complementario para tu estancia' }}</p>
                                    </div>
                                </div>
                                <span class="font-bold text-slate-700 text-sm whitespace-nowrap">{{ number_format($servicio->precio_base, 2, ',', '.') }} € <span class="text-xs font-normal text-slate-500">{{ $sufijo }}</span></span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-400 mt-4 font-normal">Precios sin IVA. Los extras seleccionados se incluyen en el resumen.</p>
                </div>
            </div>

            <!-- COLUMNA DERECHA: RESUMEN DE TU RESERVA (STICKY) -->
            <div class="lg:col-span-1">
                <div class="bg-[#f0f6fa] rounded-2xl shadow-sm border border-slate-200/90 p-6 sticky top-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Resumen de tu reserva</h2>
                    
                    <!-- Ficha identificativa del amarre seleccionado con ancla -->
                    <div class="bg-white rounded-xl p-3.5 border border-slate-200/80 mb-3 flex items-center gap-3.5 shadow-sm">
                        <div class="bg-sky-50 border border-sky-100 p-2.5 rounded-xl text-teal-700 flex items-center justify-center flex-shrink-0">
                            <!-- Icono de ancla idéntico a la imagen -->
                            <svg class="w-6 h-6 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0a8 8 0 01-8-8m8 8a8 8 0 008-8M9 4h6M12 4a2 2 0 100-4 2 2 0 000 4z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">Amarre {{ $amarre->numero }}</p>
                            <p class="text-xs text-slate-500">Marina de Málaga · Pantalán {{ $amarre->muelle->nombre ?? $amarre->letra }}</p>
                        </div>
                    </div>

                    <!-- Pastilla de Rango de Fechas dinámico -->
                    <div id="resumen-fechas-box" class="hidden bg-white border border-slate-200/80 rounded-xl px-4 py-2.5 mb-5 flex justify-between items-center text-xs font-semibold text-slate-700 shadow-sm">
                        <span id="resumen-fechas-texto">--</span>
                        <span id="resumen-noches-badge" class="bg-sky-50 text-sky-800 border border-sky-100 text-[11px] px-2.5 py-1 rounded-md font-bold">0 noches</span>
                    </div>

                    <!-- Encabezado de Desglose de Precios -->
                    <p class="text-[11px] font-bold text-sky-800 tracking-wider uppercase mb-3">DESGLOSE DEL PRECIO</p>

                    <!-- Lista de conceptos desglose -->
                    <div class="text-xs text-slate-600 mb-2">
                        <!-- Línea del coste del Amarre -->
                        <div class="flex justify-between items-center mb-2">
                            <span id="resumen-amarre-label" class="font-medium text-slate-700">Amarre · {{ number_format($amarre->tarifa_base, 2, ',', '.') }} € × 0 noches</span>
                            <span id="resumen-amarre" class="font-semibold text-slate-800">0,00 €</span>
                        </div>
                        
                        <!-- Contenedor donde se insertan los servicios seleccionados dinámicamente -->
                        <div id="contenedor-servicios-resumen" class="space-y-2 mb-2"></div>
                    </div>

                    <!-- Separador -->
                    <div class="border-t border-slate-200/80 my-3"></div>

                    <!-- Subtotal e IVA -->
                    <div class="space-y-2 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span id="resumen-subtotal" class="font-semibold text-slate-800">0,00 €</span>
                        </div>
                        <div class="flex justify-between">
                            <span>IVA (21 %)</span>
                            <span id="resumen-iva" class="font-semibold text-slate-800">0,00 €</span>
                        </div>
                    </div>

                    <!-- Separador -->
                    <div class="border-t border-slate-200/80 my-3"></div>

                    <!-- Total con IVA incluido -->
                    <div class="flex justify-between items-baseline pt-1">
                        <div>
                            <span class="text-xl font-extrabold text-slate-900 block leading-tight">Total</span>
                            <span class="text-[11px] text-slate-400 font-normal">IVA incluido</span>
                        </div>
                        <span id="resumen-total" class="text-2xl font-black text-slate-900">0,00 €</span>
                    </div>

                    <!-- Casilla de aceptación de términos -->
                    <label class="flex items-start gap-2 mb-6 cursor-pointer">
                        <input type="checkbox" id="acepto_terminos" name="acepto_terminos" required class="mt-1 w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-xs text-slate-500">
                            He leído y acepto los <a href="{{ route('legal.terminos') }}" target="_blank" class="text-teal-600 underline">Términos y Condiciones</a> 
                            y la <a href="{{ route('legal.reembolsos') }}" target="_blank" class="text-teal-600 underline">Política de Reembolsos</a>.
                        </span>
                    </label>

                    <!-- Mensaje de éxito "Todo listo para confirmar" -->
                    <p id="mensaje-listo-confirmar" class="hidden text-xs text-teal-700 font-semibold mb-4 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Todo listo para confirmar
                    </p>

                    <!-- Botón para confirmar reserva -->
                    <button type="submit" id="btn-confirmar" disabled class="w-full bg-[#0a667e] hover:bg-[#085265] text-white font-bold py-3.5 rounded-xl transition duration-150 shadow-sm text-sm flex justify-center items-center gap-2 opacity-50 cursor-not-allowed">
                        Confirmar Reserva
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <p class="text-center text-[10px] text-slate-400 mt-3 leading-normal">El botón se activa al completar y validar los campos obligatorios y aceptar las condiciones.</p>
                    <p class="text-center text-[10px] text-slate-400 mt-1 leading-normal">Ejemplo visual · No se realiza ninguna reserva ni pago.</p>
                </div>
            </div>
        </form>
    </div>

    <!-- Pasamos las variables de PHP a JavaScript de forma segura -->
    <script>
        window.tarifaBaseReserva = {{ (float)$amarre->tarifa_base }};
        window.limitesAmarre = {
            eslora: {{ (float)$amarre->eslora_max }},
            manga: {{ (float)$amarre->manga_max }},
            calado: {{ (float)$amarre->calado_max }}
        };
    </script>

    <x-cookie-banner />
    <x-ayuda-modal />
</body>
</html>