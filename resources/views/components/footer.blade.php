<footer class="bg-slate-900 text-slate-400 py-4 w-full border-t border-slate-800 mt-auto">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row justify-between items-center gap-4 text-xs">
        
        <!-- Izquierda: Copyright y datos del titular -->
        <div class="text-center lg:text-left">
            <p class="font-medium text-slate-300">
                © {{ date('Y') }} Rafael Morones Burgos · PortMálaga Management
            </p>
            <p class="text-[10px] text-slate-500 mt-0.5">
                Proyecto académico DAW · Sin actividad comercial
            </p>
        </div>

        <!-- Centro: Enlaces legales (en una sola línea o dos como máximo) -->
        <div class="flex flex-wrap justify-center gap-x-4 gap-y-2">
            <a href="{{ route('legal.aviso') }}" class="hover:text-white transition">Aviso Legal</a>
            <a href="{{ route('legal.privacidad') }}" class="hover:text-white transition">Privacidad</a>
            <a href="{{ route('legal.cookies') }}" class="hover:text-white transition">Cookies</a>
            <a href="{{ route('legal.terminos') }}" class="hover:text-white transition">Términos</a>
            <a href="{{ route('legal.reembolsos') }}" class="hover:text-white transition">Reembolsos</a>
            <a href="{{ route('contacto.index') }}" class="hover:text-white transition">Contacto</a>
        </div>

        <!-- Derecha: Email de contacto -->
        <div class="text-center lg:text-right">
            <a href="mailto:contacto@portmalaga.com" class="hover:text-white transition">
                contacto@portmalaga.com
            </a>
        </div>

    </div>
</footer>