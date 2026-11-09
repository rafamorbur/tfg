<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Política de Reembolsos - PortMálaga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col font-sans">
    <main class="flex-1 max-w-4xl mx-auto p-8 bg-white shadow-md my-8 rounded-lg w-full">
        <h1 class="text-3xl font-bold text-slate-800 mb-6">Política de Reembolsos y Cancelaciones</h1>
        
        <div class="space-y-4 text-slate-600 text-sm leading-relaxed">
            <p><strong>1. Cancelación por parte del cliente (reserva pendiente):</strong> Si la reserva está en estado <em>Pendiente</em> (aún no ha sido confirmada por el puerto), el cliente puede cancelarla desde su panel de cliente sin ningún coste. El importe abonado, si lo hubiera, se reembolsará íntegramente.</p>
            
            <p><strong>2. Cancelación por parte del cliente (reserva confirmada):</strong> Si la reserva ya ha sido confirmada por el puerto, se aplicarán las siguientes condiciones:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Cancelación con más de 7 días de antelación a la fecha de entrada: reembolso del 100% del importe.</li>
                <li>Cancelación entre 7 y 48 horas antes de la entrada: reembolso del 50%.</li>
                <li>Cancelación con menos de 48 horas o no presentación (no-show): sin reembolso.</li>
            </ul>
            
            <p><strong>3. Cancelación por parte del puerto:</strong> Si el puerto cancela la reserva por causas justificadas (avería, mantenimiento imprevisto, fuerza mayor), el cliente tendrá derecho al reembolso íntegro del importe abonado o, si lo prefiere, a la reasignación a otro amarre disponible sin coste adicional.</p>
            
            <p><strong>4. Condiciones meteorológicas:</strong> Las cancelaciones motivadas por alertas meteorológicas graves (AEMET) que impidan la navegación o el atraque se considerarán causa de fuerza mayor y darán derecho al reembolso íntegro o a la reprogramación de la estancia.</p>
            
            <p><strong>5. Cómo solicitar un reembolso:</strong> El cliente debe enviar un correo electrónico a <a href="mailto:contacto@portmalaga.com" class="text-teal-600 underline">contacto@portmalaga.com</a> indicando el código de reserva y el motivo de la cancelación. El reembolso se procesará en un plazo máximo de 14 días hábiles desde la aprobación de la solicitud.</p>
            
            <p><strong>6. Excepciones:</strong> No se admitirán reembolsos por cambios de opinión una vez iniciada la estancia, ni por daños ocasionados por el cliente en las instalaciones.</p>
        </div>
        
        <div class="mt-8 pt-4 border-t">
            <a href="{{ route('principal') }}" class="text-teal-600 hover:underline font-semibold">&larr; Volver al inicio</a>
        </div>
    </main>
    <x-footer />
    <x-cookie-banner />
</body>
</html>