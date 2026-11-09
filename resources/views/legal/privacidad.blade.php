<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Política de Privacidad - PortMálaga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans">
    <main class="flex-1 max-w-4xl mx-auto p-8 bg-white shadow-md my-8 rounded-lg w-full">
        <h1 class="text-3xl font-bold text-slate-800 mb-1">Política de Privacidad</h1>
        <p class="text-sm text-slate-400 mb-6">Última actualización: noviembre de 2026 · Versión 1.0</p>

        <div class="space-y-5 text-slate-600 text-sm leading-relaxed">

            <p><strong>1. Responsable del tratamiento</strong><br>
            El responsable del tratamiento de los datos personales recogidos en esta plataforma es <strong>Rafael Morones Burgos</strong>, con domicilio en Málaga (España) y correo electrónico de contacto <a href="mailto:contacto@portmalaga.com" class="text-teal-600 underline">contacto@portmalaga.com</a>. PortMálaga Management es un proyecto académico desarrollado para el Ciclo Formativo de Desarrollo de Aplicaciones Web.</p>

            <p><strong>2. Datos personales que recogemos</strong><br>
            Al registrarte y utilizar la plataforma tratamos las siguientes categorías de datos:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Datos identificativos:</strong> nombre, apellidos, tipo de documento (DNI, NIE o Pasaporte) y número de documento.</li>
                <li><strong>Datos de contacto:</strong> correo electrónico, teléfono y dirección postal (estos dos últimos opcionales).</li>
                <li><strong>Datos de acceso:</strong> contraseña cifrada mediante bcrypt (nunca en texto plano).</li>
                <li><strong>Datos de embarcaciones:</strong> nombre, matrícula, tipo, eslora, manga, calado, bandera, póliza de seguro, vencimiento del seguro, MMSI y capacidad.</li>
                <li><strong>Datos de reservas:</strong> fechas de entrada y salida, amarre y muelle asignados, servicios contratados, importe y estado de la reserva.</li>
                <li><strong>Datos técnicos de navegación:</strong> dirección IP, fecha y hora de acceso, y cookies técnicas de sesión y protección CSRF.</li>
            </ul>

            <p><strong>3. Finalidades del tratamiento</strong><br>
            Utilizamos tus datos para las siguientes finalidades:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Gestionar tu registro y el acceso a tu cuenta de usuario.</li>
                <li>Permitir la consulta de disponibilidad y la formalización de reservas de amarres.</li>
                <li>Gestionar tus embarcaciones y los servicios portuarios contratados.</li>
                <li>Enviar comunicaciones transaccionales relacionadas con tus reservas (confirmación, cancelación, cambios de estado).</li>
                <li>Garantizar la seguridad de la plataforma y prevenir usos fraudulentos.</li>
                <li>Cumplir con las obligaciones legales, fiscales y contables aplicables.</li>
            </ul>

            <p><strong>4. Base legal</strong><br>
            El tratamiento se fundamenta en:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Consentimiento del interesado</strong> (art. 6.1.a RGPD) para el registro y el tratamiento de tus datos personales.</li>
                <li><strong>Ejecución de un contrato</strong> (art. 6.1.b RGPD) para la gestión de reservas y servicios contratados.</li>
                <li><strong>Obligación legal</strong> (art. 6.1.c RGPD) para la conservación de datos fiscales y contables.</li>
                <li><strong>Interés legítimo</strong> (art. 6.1.f RGPD) para la seguridad de la plataforma y la prevención del fraude.</li>
            </ul>

            <p><strong>5. Plazo de conservación</strong><br>
            Los datos se conservarán:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Mientras tu cuenta permanezca activa</strong>, para poder prestarte el servicio.</li>
                <li><strong>6 años</strong> desde la última reserva, en cumplimiento del artículo 30 del Código de Comercio (obligaciones fiscales y contables).</li>
                <li><strong>5 años</strong> para atender posibles responsabilidades civiles derivadas de la relación contractual, según el artículo 1964.2 del Código Civil.</li>
            </ul>
            <p>Si solicitas la baja, tu cuenta se desactivará (bloqueo) y dejará de ser visible, pero los datos asociados a reservas y facturación se conservarán bloqueados durante los plazos legales indicados, transcurridos los cuales se suprimirán de forma segura.</p>

            <p><strong>6. Destinatarios y encargados del tratamiento</strong><br>
            Tus datos no se ceden a terceros salvo obligación legal. Para el funcionamiento de la plataforma utilizamos los siguientes proveedores que actúan como encargados del tratamiento:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Render</strong> (alojamiento web y base de datos PostgreSQL), con servidores en la Unión Europea.</li>
                <li><strong>GitHub</strong> (repositorio de código y control de versiones).</li>
            </ul>
            <p>Las APIs externas utilizadas (AEMET para meteorología y OpenStreetMap/Leaflet para mapas) no reciben datos personales tuyos, ya que las peticiones se realizan sin identificadores de usuario.</p>

            <p><strong>7. Derechos del interesado</strong><br>
            Puedes ejercer en cualquier momento los siguientes derechos:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Acceso:</strong> consultar qué datos tenemos sobre ti.</li>
                <li><strong>Rectificación:</strong> corregir datos inexactos o incompletos.</li>
                <li><strong>Supresión:</strong> solicitar la eliminación de tus datos cuando ya no sean necesarios.</li>
                <li><strong>Limitación:</strong> solicitar que se limite el tratamiento de tus datos.</li>
                <li><strong>Oposición:</strong> oponerte al tratamiento basado en interés legítimo.</li>
                <li><strong>Portabilidad:</strong> recibir tus datos en un formato estructurado y de uso común.</li>
            </ul>
            <p>Puedes ejercer estos derechos desde la sección <em>Mis Datos</em> de tu panel de cliente o enviando un correo a <a href="mailto:contacto@portmalaga.com" class="text-teal-600 underline">contacto@portmalaga.com</a>, indicando el derecho que deseas ejercer y adjuntando copia de tu documento de identidad. Responderemos en un plazo máximo de un mes.</p>
            <p>Si consideras que no hemos atendido correctamente tus derechos, puedes presentar una reclamación ante la <strong>Agencia Española de Protección de Datos (AEPD)</strong>, en <a href="https://www.aepd.es" target="_blank" class="text-teal-600 underline">www.aepd.es</a>.</p>

            <p><strong>8. Menores de edad</strong><br>
            El consentimiento para el tratamiento de datos personales en servicios de la sociedad de la información puede otorgarse a partir de los <strong>14 años</strong>, conforme a la LOPDGDD. No obstante, para la formalización de reservas (contrato de arrendamiento del amarre) se exige ser <strong>mayor de 18 años</strong> y tener capacidad legal para contratar. Si eres menor de 14 años, no debes registrarte sin autorización de tus padres o tutores.</p>

            <p><strong>9. Medidas de seguridad</strong><br>
            Aplicamos medidas técnicas y organizativas para proteger tus datos: cifrado de contraseñas con bcrypt, conexión segura mediante HTTPS, control de acceso basado en roles mediante middleware, validación de datos en servidor y copias de seguridad periódicas de la base de datos.</p>

            <p><strong>10. Cookies</strong><br>
            La plataforma utiliza únicamente cookies técnicas necesarias para el funcionamiento del sitio (sesión y protección CSRF). Puedes consultar el detalle en nuestra <a href="{{ route('legal.cookies') }}" class="text-teal-600 underline">Política de Cookies</a>.</p>

            <p><strong>11. Modificaciones de esta política</strong><br>
            Podemos actualizar esta Política de Privacidad para adaptarla a cambios normativos o a nuevas funcionalidades de la plataforma. La versión vigente será siempre la publicada en esta página, indicando la fecha de última actualización.</p>

        </div>

        <div class="mt-10 pt-4 border-t">
            <a href="{{ route('principal') }}" class="text-teal-600 hover:underline font-semibold">&larr; Volver al inicio</a>
        </div>
    </main>
    <x-footer />
    <x-cookie-banner />
</body>
</html>