<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Política de Cookies - PortMálaga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans">
    <main class="flex-1 max-w-4xl mx-auto p-8 bg-white shadow-md my-8 rounded-lg w-full">
        <h1 class="text-3xl font-bold text-slate-800 mb-6">Política de Cookies</h1>
        <div class="space-y-4 text-slate-600 text-sm leading-relaxed">
            <p>Este sitio web utiliza cookies para garantizar su correcto funcionamiento y mejorar la experiencia del usuario.</p>
            <p><strong>Cookies técnicas (Laravel):</strong> Son estrictamente necesarias. Se utilizan para mantener la sesión del usuario iniciada y proteger los formularios contra ataques CSRF. No recopilan datos personales ni se comparten con terceros.</p>
            <p><strong>Cookies de terceros (Mapas y AEMET):</strong> Al visualizar los mapas interactivos, OpenStreetMap y Leaflet pueden establecer cookies propias. No las utilizamos con fines publicitarios.</p>
            <p><strong>Desactivar cookies:</strong> Puedes desactivarlas en tu navegador, pero si desactivas las cookies técnicas, no podrás iniciar sesión ni realizar reservas.</p>
        </div>
        <div class="mt-8 pt-4 border-t">
            <a href="{{ route('principal') }}" class="text-teal-600 hover:underline font-semibold">&larr; Volver al inicio</a>
        </div>
    </main>
    <x-footer />
    <x-cookie-banner />
</body>
</html>