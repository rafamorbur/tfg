@extends('layouts.admin')

@section('content')

    <!-- ========================================== -->
    <!-- SECCIÓN 1: RESERVAS (Visible por defecto)  -->
    <!-- ========================================== -->
    <div id="seccion-reservas" class="block">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Bandeja de Entrada: Reservas Pendientes</h1>
        </div>

        <!-- TABLA DE RESERVAS PENDIENTES -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-12">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100 text-slate-600 text-sm font-semibold">
                    <tr>
                        <th class="p-4 border-b">Código</th>
                        <th class="p-4 border-b">Cliente</th>
                        <th class="p-4 border-b">Embarcación</th>
                        <th class="p-4 border-b">Muelle / Amarre</th>
                        <th class="p-4 border-b">Fechas</th>
                        <th class="p-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($reservasPendientes as $reserva)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-mono font-medium">{{ $reserva->codigo_reserva }}</td>
                            <td class="p-4">
                                <div class="font-semibold">{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellidos }}</div>
                                <div class="text-xs text-slate-500">{{ $reserva->usuario->email }}</div>
                            </td>
                            <td class="p-4">
                                <div>{{ $reserva->embarcacion->nombre }}</div>
                                <div class="text-xs text-slate-500">{{ $reserva->embarcacion->matricula }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-slate-800">{{ $reserva->amarre->muelle->nombre }}</div>
                                <div class="text-xs text-slate-500">Amarre: {{ $reserva->amarre->numero }}</div>
                            </td>
                            <td class="p-4 text-xs">
                                <div>Entrada: {{ \Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }}</div>
                                <div>Salida: {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}</div>
                            </td>
                            <td class="p-4">
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.reserva.aceptar', $reserva->id_reserva) }}" method="POST" onsubmit="return confirm('¿Aceptar esta reserva?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-md text-xs font-bold transition">Aceptar</button>
                                    </form>
                                    <form action="{{ route('admin.reserva.denegar', $reserva->id_reserva) }}" method="POST" onsubmit="return confirm('¿Denegar esta reserva?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-bold transition">Denegar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">No hay reservas pendientes en este momento.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- TABLA DE HISTORIAL -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-700">Historial de Reservas</h2>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-sm font-semibold">
                    <tr>
                        <th class="p-4 border-b">Código</th>
                        <th class="p-4 border-b">Cliente</th>
                        <th class="p-4 border-b">Muelle / Amarre</th>
                        <th class="p-4 border-b">Fechas</th>
                        <th class="p-4 border-b">Estado</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($reservasHistorial as $reserva)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-mono font-medium text-slate-500">{{ $reserva->codigo_reserva }}</td>
                            <td class="p-4">{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellidos }}</td>
                            <td class="p-4">{{ $reserva->amarre->muelle->nombre }} - {{ $reserva->amarre->numero }}</td>
                            <td class="p-4 text-xs">
                                {{ \Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}
                            </td>
                            <td class="p-4">
                                @if($reserva->estado === 'confirmada')
                                    <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-bold">Confirmada</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-bold">Cancelada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 italic">Aún no hay historial de reservas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECCIÓN 2: AMARRES (Oculta por defecto)    -->
    <!-- ========================================== -->
    <div id="seccion-amarres" class="hidden">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Control de Amarres</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100 text-slate-600 text-sm font-semibold">
                    <tr>
                        <th class="p-4 border-b">Muelle</th>
                        <th class="p-4 border-b">Amarre</th>
                        <th class="p-4 border-b">Dimensiones Máx.</th>
                        <th class="p-4 border-b">Estado Actual</th>
                        <th class="p-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($amarres as $amarre)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-semibold text-slate-800">{{ $amarre->muelle->nombre }}</td>
                            <td class="p-4 font-mono">{{ $amarre->numero }}</td>
                            <td class="p-4 text-xs">{{ $amarre->eslora_max }}m x {{ $amarre->manga_max }}m x {{ $amarre->calado_max }}m</td>
                            <td class="p-4">
                                @if($amarre->estado === 'disponible')
                                    <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-bold">Disponible</span>
                                @elseif($amarre->estado === 'ocupado')
                                    <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-bold">Ocupado</span>
                                @else
                                    <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full text-xs font-bold">Mantenimiento</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <form action="{{ route('admin.amarres.update', $amarre->id_amarre) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="estado" class="border-slate-300 rounded-lg text-xs py-1.5 focus:border-teal-500 focus:ring-teal-500">
                                        <option value="disponible" {{ $amarre->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="ocupado" {{ $amarre->estado == 'ocupado' ? 'selected' : '' }}>Ocupado</option>
                                        <option value="mantenimiento" {{ $amarre->estado == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                    </select>
                                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Actualizar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">No hay amarres registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
        <!-- ========================================== -->
    <!-- SECCIÓN 3: USUARIOS (Solo Admin)           -->
    <!-- ========================================== -->
    @if(Auth::user()->id_rol == 3)
    <div id="seccion-usuarios" class="hidden">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Administración de Usuarios</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100 text-slate-600 text-sm font-semibold">
                    <tr>
                        <th class="p-4 border-b">Usuario</th>
                        <th class="p-4 border-b">Documento</th>
                        <th class="p-4 border-b">Rol Actual</th>
                        <th class="p-4 border-b">Estado</th>
                        <th class="p-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @foreach($usuarios as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4">
                                <div class="font-semibold text-slate-800">{{ $user->nombre }} {{ $user->apellidos }}</div>
                                <div class="text-xs text-slate-500">{{ $user->email }}</div>
                            </td>
                            <td class="p-4 text-xs">
                                {{ $user->documento_tipo }}: {{ $user->numero_documento }}
                            </td>
                            <td class="p-4">
                                <!-- Formulario para cambiar el rol -->
                                <form action="{{ route('admin.usuarios.rol', $user->id_usuario) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="id_rol" class="border-slate-300 rounded-lg text-xs py-1.5 focus:border-teal-500" {{ $user->id_usuario === Auth::id() ? 'disabled' : '' }}>
                                        <option value="1" {{ $user->id_rol == 1 ? 'selected' : '' }}>Cliente</option>
                                        <option value="2" {{ $user->id_rol == 2 ? 'selected' : '' }}>Empleado</option>
                                        <option value="3" {{ $user->id_rol == 3 ? 'selected' : '' }}>Administrador</option>
                                    </select>
                                    @if($user->id_usuario !== Auth::id())
                                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-2 py-1.5 rounded text-xs font-bold transition">Cambiar</button>
                                    @endif
                                </form>
                            </td>
                            <td class="p-4">
                                @if($user->activo)
                                    <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-bold">Activo</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-bold">Inactivo</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <!-- Formulario para activar/desactivar -->
                                @if($user->id_usuario !== Auth::id())
                                <form action="{{ route('admin.usuarios.estado', $user->id_usuario) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres cambiar el estado de este usuario?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $user->activo ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-800' }} font-medium text-xs underline">
                                        {{ $user->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                @else
                                    <span class="text-slate-400 text-xs italic">Tu cuenta</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

@endsection