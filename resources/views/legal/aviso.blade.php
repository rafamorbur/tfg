<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aviso Legal - PortMálaga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans">
    <main class="flex-1 max-w-4xl mx-auto p-8 bg-white shadow-md my-8 rounded-lg w-full">
        <h1 class="text-3xl font-bold text-slate-800 mb-1">Aviso Legal</h1>
        <p class="text-sm text-slate-400 mb-6">Última actualización: noviembre de 2026</p>

        <div class="space-y-5 text-slate-600 text-sm leading-relaxed">

            <p><strong>1. Datos identificativos del titular</strong><br>
            En cumplimiento del artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y de Comercio Electrónico (LSSI-CE), se informa de los siguientes datos:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Titular:</strong> Rafael Morones Burgos</li>
                <li><strong>Domicilio:</strong> Málaga, España</li>
                <li><strong>Correo electrónico de contacto:</strong> <a href="mailto:contacto@portmalaga.com" class="text-teal-600 underline">contacto@portmalaga.com</a></li>
                <li><strong>Actividad:</strong> Proyecto académico de desarrollo de aplicaciones web (Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web).</li>
            </ul>
            <p class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-xs text-slate-500">
                <strong>Nota:</strong> PortMálaga Management es un proyecto académico sin actividad comercial. No se realizan reservas ni cobros reales. Por este motivo, no procede la inscripción en el Registro Mercantil ni la disposición de un NIF de actividad económica. Los datos aquí mostrados tienen carácter exclusivamente informativo y académico.
            </p>

            <p><strong>2. Objeto</strong><br>
            La finalidad de esta plataforma es la consulta de disponibilidad y la reserva simulada de amarres en los puertos deportivos de la provincia de Málaga, así como la contratación de servicios portuarios adicionales, todo ello en el marco de un proyecto académico.</p>

            <p><strong>3. Condiciones de uso</strong><br>
            El acceso a la plataforma es gratuito y no exige registro previo para la consulta del mapa y de la disponibilidad. Para formalizar una reserva es necesario registrarse como cliente y aceptar los Términos y Condiciones y la Política de Privacidad.</p>

            <p><strong>4. Propiedad intelectual e industrial</strong><br>
            El código fuente, el diseño, la estructura de navegación y los contenidos de esta plataforma son de elaboración propia del titular. Queda prohibida su reproducción total o parcial, su distribución o su transformación sin autorización expresa. Las librerías de terceros utilizadas (Laravel, Tailwind CSS, Leaflet) están sujetas a sus propias licencias de código abierto.</p>

            <p><strong>5. Exclusión de responsabilidad</strong><br>
            Al tratarse de un entorno académico, los datos mostrados (muelles, amarres, reservas, tarifas y meteorología) son simulados o de carácter demostrativo. El titular no se hace responsable del uso indebido de la plataforma ni de las decisiones que terceros pudieran tomar a partir de la información mostrada.</p>

            <p><strong>6. Enlaces a terceros</strong><br>
            La plataforma utiliza servicios de terceros para el mapa (OpenStreetMap y Leaflet) y para la información meteorológica (AEMET). El titular no se hace responsable del contenido ni de las políticas de privacidad de dichos servicios.</p>

            <p><strong>7. Legislación aplicable y jurisdicción</strong><br>
            Las presentes condiciones se rigen por la legislación española. Cualquier controversia derivada del uso de la plataforma se someterá a los juzgados y tribunales de Málaga.</p>

        </div>

        <div class="mt-10 pt-4 border-t">
            <a href="{{ route('principal') }}" class="text-teal-600 hover:underline font-semibold">&larr; Volver al inicio</a>
        </div>
    </main>
    <x-footer />
    <x-cookie-banner />
</body>
</html>