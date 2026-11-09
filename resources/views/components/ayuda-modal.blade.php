<!-- Botón Flotante de Ayuda -->
<button id="btn-open-help" 
        type="button"
        class="fixed bottom-6 right-6 bg-teal-700 hover:bg-teal-600 text-white p-3.5 sm:px-4 sm:py-2.5 rounded-full shadow-2xl hover:shadow-teal-900/30 transition-all duration-200 z-[10000] flex items-center gap-2 focus:ring-4 focus:ring-teal-300 hover:scale-105 group border border-teal-500/30" 
        title="Centro de Ayuda">
    <svg class="w-6 h-6 text-teal-100 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="hidden sm:inline font-bold text-xs tracking-wide">Ayuda</span>
</button>

<!-- Modal de Ayuda -->
<div id="help-modal" class="hidden fixed inset-0 bg-black/60 z-[10001] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
        
        <!-- Cabecera del Modal -->
        <div class="bg-teal-900 p-5 flex justify-between items-center text-white shrink-0">
            <h3 class="font-bold text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Centro de Ayuda
            </h3>
            <button id="btn-close-help" class="text-teal-200 hover:text-white text-2xl font-bold leading-none">&times;</button>
        </div>

        <!-- Contenido Dinámico según Rol -->
        <div class="p-6 overflow-y-auto text-slate-600 text-sm space-y-4">
            
            @guest
                <!-- AYUDA PARA INVITADOS -->
                <h4 class="text-lg font-bold text-slate-800 border-b pb-2 mb-4">Bienvenido a PortMálaga</h4>
                <p>Estás explorando la plataforma como visitante. Desde aquí puedes consultar la disponibilidad de amarres en tiempo real.</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Usa el <strong>mapa interactivo</strong> para ver los puertos de Málaga.</li>
                    <li>Haz clic en los <strong>pines azules</strong> para ver los detalles de cada muelle y sus pantalanes.</li>
                    <li>Si quieres reservar un amarre, necesitas <strong>iniciar sesión</strong> o <strong>registrarte</strong>.</li>
                </ul>
            @endguest

            @auth
                @if(Auth::user()->id_rol == 1)
                    <!-- AYUDA PARA CLIENTES -->
                    <h4 class="text-lg font-bold text-slate-800 border-b pb-2 mb-4">Guía para Clientes</h4>
                    <p>Como cliente, tu objetivo es reservar un amarre para tu embarcación. Sigue estos pasos:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>1. Busca:</strong> Filtra por fechas y dimensiones en el panel izquierdo del mapa.</li>
                        <li><strong>2. Selecciona:</strong> Haz clic en un muelle, elige un amarre en verde (disponible) y pulsa "Hacer Reserva".</li>
                        <li><strong>3. Confirma:</strong> Revisa el precio, elige tu barco y los servicios extra, y confirma.</li>
                        <li><strong>Mis Reservas:</strong> Puedes ver el estado de tus reservas y cancelarlas (si están pendientes) desde tu panel privado.</li>
                        <li><strong>Mis Barcos:</strong> Recuerda que debes tener tu embarcación registrada antes de reservar.</li>
                    </ul>
                @elseif(Auth::user()->id_rol == 2)
                    <!-- AYUDA PARA EMPLEADOS -->
                    <h4 class="text-lg font-bold text-slate-800 border-b pb-2 mb-4">Guía para Personal de Puerto</h4>
                    <p>Como empleado, gestionas las operaciones de tu muelle asignado.</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Gestión de Reservas:</strong> Revisa la bandeja de entrada. Usa los botones verdes para Aceptar o rojos para Denegar.</li>
                        <li><strong>Control de Amarres:</strong> Consulta el estado técnico de los amarres de tu muelle y cámbialo a "Mantenimiento" si es necesario.</li>
                        <li><em>Nota:</em> Solo tienes acceso a los datos de tu muelle.</li>
                    </ul>
                @elseif(Auth::user()->id_rol == 3)
                    <!-- AYUDA PARA ADMINISTRADORES -->
                    <h4 class="text-lg font-bold text-slate-800 border-b pb-2 mb-4">Guía para Administradores</h4>
                    <p>Tienes acceso total al sistema y control global sobre la plataforma.</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Gestión Global:</strong> Puedes gestionar reservas y amarres de todos los muelles, no solo de uno.</li>
                        <li><strong>Usuarios:</strong> Desde la pestaña de Administración, puedes cambiar el rol de un usuario (Cliente, Empleado, Admin) o desactivar su cuenta por seguridad.</li>
                        <li><em>Recuerda:</em> Por seguridad, no puedes desactivar tu propia cuenta ni cambiarte el rol a ti mismo.</li>
                    </ul>
                @endif
            @endauth

        </div>
        
        <!-- Pie del Modal -->
        <div class="bg-slate-50 p-4 border-t border-slate-200 flex justify-end shrink-0">
            <button id="btn-close-help-bottom" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 px-6 rounded-lg transition text-sm">
                Entendido
            </button>
        </div>
    </div>
</div>