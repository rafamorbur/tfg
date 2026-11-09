document.addEventListener("DOMContentLoaded", function () {
    // Seleccionamos los botones del menú
    let btnReservas = document.getElementById("btn-menu-reservas");
    let btnAmarres = document.getElementById("btn-menu-amarres");
    let btnUsuarios = document.getElementById("btn-menu-usuarios"); // Botón de usuarios

    // Seleccionamos las secciones
    let seccionReservas = document.getElementById("seccion-reservas");
    let seccionAmarres = document.getElementById("seccion-amarres");
    let seccionUsuarios = document.getElementById("seccion-usuarios"); // Sección de usuarios

    function cambiarSeccion(seccionActiva, botonActivo) {
        // Ocultamos todas las secciones
        seccionReservas.classList.add("hidden");
        seccionAmarres.classList.add("hidden");
        if (seccionUsuarios) seccionUsuarios.classList.add("hidden");

        // Mostramos la seleccionada
        seccionActiva.classList.remove("hidden");

        // Limpiamos los estilos de los botones
        let botones = [btnReservas, btnAmarres, btnUsuarios];
        for (let boton of botones) {
            if (boton) {
                boton.classList.remove("bg-teal-600", "text-white");
                boton.classList.add("text-slate-300", "hover:bg-slate-700");
            }
        }

        // Pintamos el botón activo
        botonActivo.classList.add("bg-teal-600", "text-white");
        botonActivo.classList.remove("text-slate-300", "hover:bg-slate-700");
    }

    // Asignamos los eventos a los botones
    btnReservas.addEventListener("click", () =>
        cambiarSeccion(seccionReservas, btnReservas),
    );
    btnAmarres.addEventListener("click", () =>
        cambiarSeccion(seccionAmarres, btnAmarres),
    );

    // Solo añadimos el evento si el botón existe (porque los empleados no lo tienen)
    if (btnUsuarios) {
        btnUsuarios.addEventListener("click", () =>
            cambiarSeccion(seccionUsuarios, btnUsuarios),
        );
    }
});
