<div id="cookie-banner" class="hidden fixed bottom-0 left-0 w-full bg-slate-900 text-white p-4 sm:p-5 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-[9999] border-t border-slate-800">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-5">
        <p class="text-sm text-slate-300 leading-relaxed">
            Utilizamos cookies técnicas para el correcto funcionamiento de la web (sesión y seguridad). 
            No utilizamos cookies publicitarias ni de seguimiento. Puedes leer más en nuestra 
            <a href="{{ route('legal.cookies') }}" class="text-teal-400 underline hover:text-teal-300 font-medium transition">Política de Cookies</a>.
        </p>
        <div class="flex items-center gap-4 shrink-0 w-full md:w-auto justify-end">
            <button id="cookie-reject" class="text-sm font-medium text-slate-300 hover:text-white underline transition">
                Solo las necesarias
            </button>
            <button id="cookie-accept" class="bg-teal-600 hover:bg-teal-500 text-white text-sm font-bold py-2.5 px-6 rounded-lg transition shadow-sm">
                Aceptar todas
            </button>
        </div>
    </div>
</div>