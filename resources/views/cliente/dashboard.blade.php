@extends('layouts.cliente')

@section('content')

    <!-- SECCIÓN RESERVAS (será la parte visible por defecto) -->
    <div id="seccion-reservas" class="block">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Mis Reservas</h1>
            <a href="{{ route('principal') }}" class="bg-teal-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-teal-700 transition">
                + Nueva Reserva
            </a>
        </div>

        <!-- mostramos una tabla con las reservas actuales -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100 text-slate-600 text-sm font-semibold">
                    <tr>
                        <th class="p-4 border-b">Código</th>
                        <th class="p-4 border-b">Muelle / Amarre</th>
                        <th class="p-4 border-b">Fechas</th>
                        <th class="p-4 border-b">Estado</th>
                        <th class="p-4 border-b">Total</th>
                        <th class="p-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($reservas as $reserva)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-mono font-medium">{{ $reserva->codigo_reserva }}</td>
                            <td class="p-4">
                                <div class="font-semibold text-slate-800">{{ $reserva->amarre->muelle->nombre }}</div>
                                <div class="text-xs text-slate-500">Amarre: {{ $reserva->amarre->numero }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-xs">{{ \Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }}</div>
                                <div class="text-xs text-slate-500">al {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}</div>
                            </td>
                            <td class="p-4">
                                @if($reserva->estado === 'pendiente')
                                    <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full text-xs font-bold">Pendiente</span>
                                @elseif($reserva->estado === 'confirmada')
                                    <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-bold">Confirmada</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-bold">Cancelada</span>
                                @endif
                            </td>
                            <td class="p-4 font-bold">{{ $reserva->precio_total }} €</td>
                            <td class="p-4">
                                @if($reserva->estado === 'pendiente')
                                    <!-- Formulario Cancelar sin onsubmit -->
                                    <form action="{{ route('cliente.reserva.cancelar', $reserva->id_reserva) }}" method="POST" class="form-cancelar-reserva">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs underline">Cancelar</button>
                                    </form>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                No tienes reservas todavía. <a href="{{ route('principal') }}" class="text-teal-600 underline">¡Ve al mapa a buscar tu amarre!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECCIÓN EMBARCACIONES (siempre estará oculta por defecto) -->
    <div id="seccion-barcos" class="hidden">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Mis Embarcaciones</h1>
            <!-- Botón que abre el modal -->
            <button id="btn-abrir-modal-barco" class="bg-teal-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-teal-700 transition">
                + Añadir Barco
            </button>
        </div>

        <!-- Tabla de Barcos -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100 text-slate-600 text-sm font-semibold">
                    <tr>
                        <th class="p-4 border-b">Nombre</th>
                        <th class="p-4 border-b">Matrícula</th>
                        <th class="p-4 border-b">Tipo</th>
                        <th class="p-4 border-b">Dimensiones (E/M/C)</th>
                        <th class="p-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($embarcaciones as $barco)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-slate-800">{{ $barco->nombre }}</td>
                            <td class="p-4 font-mono">{{ $barco->matricula }}</td>
                            <td class="p-4">{{ $barco->tipo ?? 'No especificado' }}</td>
                            <td class="p-4 text-xs">
                                {{ $barco->eslora }}m / {{ $barco->manga }}m / {{ $barco->calado }}m
                            </td>
                            <td class="p-4">
                                <!-- Botón Editar con atributos data- para el JS -->
                                <button type="button" 
                                        class="btn-editar-barco text-teal-600 hover:text-teal-800 font-medium text-xs underline mr-2"
                                        data-id="{{ $barco->id_embarcacion }}"
                                        data-nombre="{{ $barco->nombre }}"
                                        data-matricula="{{ $barco->matricula }}"
                                        data-tipo="{{ $barco->tipo }}"
                                        data-eslora="{{ $barco->eslora }}"
                                        data-manga="{{ $barco->manga }}"
                                        data-calado="{{ $barco->calado }}">
                                    Editar
                                </button>
                                
                                <!-- Formulario Eliminar sin onsubmit -->
                                <form action="{{ route('cliente.barcos.destroy', $barco->id_embarcacion) }}" method="POST" class="inline form-eliminar-barco">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                No tienes embarcaciones registradas. ¡Añade una para poder reservar!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECCIÓN DATOS PERSONALES (siempre estará oculta por defecto)  -->
    <div id="seccion-datos" class="hidden">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Mis Datos</h1>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('cliente.datos.update') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- Bloque de errores -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-lg mb-4">
                        <ul class="text-sm text-red-700 list-disc list-inside font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', Auth::user()->nombre) }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('nombre') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Apellidos</label>
                        <input type="text" name="apellidos" value="{{ old('apellidos', Auth::user()->apellidos) }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('apellidos') border-red-500 @enderror">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('email') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Teléfono (Opcional)</label>
                        <input type="text" name="telefono" value="{{ old('telefono', Auth::user()->telefono) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Dirección (Opcional)</label>
                    <input type="text" name="direccion" value="{{ old('direccion', Auth::user()->direccion) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                </div>

                <!-- Datos no editables (solo lectura) -->
                <div class="bg-slate-50 p-4 rounded-lg mt-4 border border-slate-200">
                    <p class="text-xs text-slate-500 mb-2 font-semibold uppercase tracking-wider">Documentación (No editable)</p>
                    <div class="flex gap-6 text-sm text-slate-700">
                        <p><strong>Tipo:</strong> {{ Auth::user()->documento_tipo }}</p>
                        <p><strong>Número:</strong> {{ Auth::user()->numero_documento }}</p>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-teal-800 text-white font-semibold py-2 px-6 rounded-lg hover:bg-teal-700 transition shadow-md">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PARA AÑADIR BARCO -->
    <div id="modal-barco" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="bg-teal-800 p-4 flex justify-between items-center text-white">
                <h3 class="font-bold">Añadir Nueva Embarcación</h3>
                <button id="btn-cerrar-modal" class="text-white hover:text-red-300 text-xl font-bold">&times;</button>
            </div>
            
            <form action="{{ route('cliente.barcos.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                
                <!-- Bloque de errores (por si falla la validación) -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-lg mb-4">
                        <ul class="text-sm text-red-700 list-disc list-inside font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre del barco</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('nombre') border-red-500 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Matrícula</label>
                    <input type="text" name="matricula" value="{{ old('matricula') }}" required placeholder="Ej: MAT-1234" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('matricula') border-red-500 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tipo (Opcional)</label>
                    <select name="tipo" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">-- Selecciona un tipo --</option>
                        <option value="Velero" {{ old('tipo') == 'Velero' ? 'selected' : '' }}>Velero</option>
                        <option value="Motora" {{ old('tipo') == 'Motora' ? 'selected' : '' }}>Motora</option>
                        <option value="Yate" {{ old('tipo') == 'Yate' ? 'selected' : '' }}>Yate</option>
                        <option value="Catamarán" {{ old('tipo') == 'Catamarán' ? 'selected' : '' }}>Catamarán</option>
                        <option value="Lancha" {{ old('tipo') == 'Lancha' ? 'selected' : '' }}>Lancha</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Eslora (m)</label>
                        <input type="number" step="0.01" name="eslora" value="{{ old('eslora') }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('eslora') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Manga (m)</label>
                        <input type="number" step="0.01" name="manga" value="{{ old('manga') }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('manga') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Calado (m)</label>
                        <input type="number" step="0.01" name="calado" value="{{ old('calado') }}" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('calado') border-red-500 @enderror">
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" id="btn-cancelar-modal" class="w-1/3 bg-slate-200 text-slate-700 font-semibold py-2 rounded-lg hover:bg-slate-300 transition">Cancelar</button>
                    <button type="submit" class="w-2/3 bg-teal-800 text-white font-semibold py-2 rounded-lg hover:bg-teal-700 transition">Guardar Barco</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PARA EDITAR BARCO -->
    <div id="modal-editar-barco" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="bg-teal-800 p-4 flex justify-between items-center text-white">
                <h3 class="font-bold">Editar Embarcación</h3>
                <button id="btn-cerrar-modal-editar" class="text-white hover:text-red-300 text-xl font-bold">&times;</button>
            </div>
            
            <form id="form-editar-barco" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre del barco</label>
                    <input type="text" id="edit-nombre" name="nombre" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Matrícula</label>
                    <input type="text" id="edit-matricula" name="matricula" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tipo</label>
                    <select id="edit-tipo" name="tipo" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">-- Selecciona un tipo --</option>
                        <option value="Velero">Velero</option>
                        <option value="Motora">Motora</option>
                        <option value="Yate">Yate</option>
                        <option value="Catamarán">Catamarán</option>
                        <option value="Lancha">Lancha</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Eslora (m)</label>
                        <input type="number" step="0.01" id="edit-eslora" name="eslora" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Manga (m)</label>
                        <input type="number" step="0.01" id="edit-manga" name="manga" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Calado (m)</label>
                        <input type="number" step="0.01" id="edit-calado" name="calado" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" id="btn-cancelar-modal-editar" class="w-1/3 bg-slate-200 text-slate-700 font-semibold py-2 rounded-lg hover:bg-slate-300 transition">Cancelar</button>
                    <button type="submit" class="w-2/3 bg-teal-800 text-white font-semibold py-2 rounded-lg hover:bg-teal-700 transition">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

@endsection