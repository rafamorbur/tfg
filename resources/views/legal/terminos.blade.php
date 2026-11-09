<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Términos y Condiciones - PortMálaga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans">
    <main class="flex-1 max-w-4xl mx-auto p-8 bg-white shadow-md my-8 rounded-lg w-full">
        <h1 class="text-3xl font-bold text-slate-800 mb-6">Términos y Condiciones</h1>
        
        <div class="space-y-4 text-slate-600 text-sm leading-relaxed">
            <p><strong>1. Objeto:</strong> PortMálaga Management es una plataforma web académica que permite la consulta de disponibilidad y la reserva de amarres en puertos deportivos de la provincia de Málaga, así como la contratación de servicios portuarios adicionales.</p>
            
            <p><strong>2. Condiciones de uso:</strong> El usuario se compromete a hacer un uso lícito de la plataforma, no realizar reservas falsas y proporcionar información veraz. El acceso a la reserva de amarres requiere estar registrado como cliente.</p>
            
            <p><strong>3. Reservas y disponibilidad:</strong> La disponibilidad mostrada en el mapa es orientativa y se actualiza en tiempo real según las reservas confirmadas. La reserva queda en estado <em>Pendiente</em> hasta que el personal del puerto la valide. PortMálaga no garantiza la disponibilidad hasta que la reserva sea confirmada.</p>
            
            <p><strong>4. Precios y pagos:</strong> Los precios mostrados incluyen el IVA correspondiente (21%). El importe total se calcula en función de los días de estancia y los servicios contratados. El pago se realizará en el puerto en el momento del check-in, salvo que se indique lo contrario.</p>
            
            <p><strong>5. Cancelaciones:</strong> El cliente puede cancelar una reserva en estado <em>Pendiente</em> sin coste alguno. Las condiciones para reservas confirmadas se detallan en la <a href="{{ route('legal.reembolsos') }}" class="text-teal-600 underline">Política de Reembolsos</a>.</p>
            
            <p><strong>6. Responsabilidad:</strong> PortMálaga actúa como intermediario entre el cliente y el puerto. No se hace responsable de daños ocasionados por terceros, condiciones meteorológicas adversas o fuerza mayor.</p>
            
            <p><strong>7. Propiedad intelectual:</strong> El código fuente, el diseño y los contenidos de esta plataforma son de elaboración propia y están protegidos por la normativa de propiedad intelectual.</p>
            
            <p><strong>8. Legislación aplicable:</strong> Estos términos se rigen por la legislación española. Cualquier controversia se someterá a los juzgados y tribunales de Málaga.</p>
        </div>
        
        <div class="mt-8 pt-4 border-t">
            <a href="{{ route('principal') }}" class="text-teal-600 hover:underline font-semibold">&larr; Volver al inicio</a>
        </div>
    </main>
    <x-footer />
    <x-cookie-banner />
</body>
</html>