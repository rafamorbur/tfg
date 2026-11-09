document.addEventListener("DOMContentLoaded", function () {
    /**
     * LOGICA PARA CAMBIAR DE SECCIÓN DENTRO DE MI PANEL
     */
    // Seleccionamos los botones y las secciones por su ID y las guardamos en variables
    let btnReservas = document.getElementById("btn-menu-reservas");
    let btnBarcos = document.getElementById("btn-menu-barcos");
    let btnDatos = document.getElementById("btn-menu-datos");

    let seccionReservas = document.getElementById("seccion-reservas");
    let seccionBarcos = document.getElementById("seccion-barcos");
    let seccionDatos = document.getElementById("seccion-datos");

    // Creamos una función que oculte todas las secciones y active el botón
    function cambiarSeccion(seccionActiva, botonActivo) {
        // Ocultamos todas las secciones por defecto
        seccionReservas.classList.add("hidden");
        seccionBarcos.classList.add("hidden");
        seccionDatos.classList.add("hidden");

        //la sección sobre la uqe hacemos click le quitamos la mostramos
        seccionActiva.classList.remove("hidden");

        // Limpiamos los estilos de todos los botones
        let botones = [btnReservas, btnBarcos, btnDatos];
        for (let boton of botones) {
            boton.classList.remove("bg-teal-50", "text-teal-800");
            boton.classList.add("text-slate-600", "hover:bg-slate-50");
        }

        // Pintamos el botón activo
        botonActivo.classList.add("bg-teal-50", "text-teal-800");
        botonActivo.classList.remove("text-slate-600", "hover:bg-slate-50");
    }

    // Asignamos los eventos a cada boton
    btnReservas.addEventListener("click", function () {
        cambiarSeccion(seccionReservas, btnReservas);
    });

    btnBarcos.addEventListener("click", function () {
        cambiarSeccion(seccionBarcos, btnBarcos);
    });

    btnDatos.addEventListener("click", function () {
        cambiarSeccion(seccionDatos, btnDatos);
    });

    /**
     * LOGICA PARA AÑADIR UN NUEVO BARCO
     */
    // Seleccionamos los botones y las secciones por su ID y las guardamos en variables
    let modalBarco = document.getElementById("modal-barco");
    let btnAbrirModal = document.getElementById("btn-abrir-modal-barco");
    let btnCerrarModal = document.getElementById("btn-cerrar-modal");
    let btnCancelarModal = document.getElementById("btn-cancelar-modal");

    //el modal se abre al hacer click en añadir barco
    btnAbrirModal.addEventListener("click", function () {
        modalBarco.classList.remove("hidden");
    });

    // Creamos una función para cerrar el formulario
    function cerrarModal() {
        modalBarco.classList.add("hidden");
    }

    //El formulario se puede cerrar de varias formas
    btnCerrarModal.addEventListener("click", cerrarModal);
    btnCancelarModal.addEventListener("click", cerrarModal);

    // Si el div rojo existe significa que hay errores de validación
    // Abrimos otra vez el modal
    if (document.querySelector("#modal-barco .bg-red-50")) {
        modalBarco.classList.remove("hidden");
    }

    /**
     * LOGICA PARA EDITAR UNA EMBARCACIÓN
     */
    // Seleccionamos los botones y las secciones por su ID y las guardamos en variables
    let modalEditarBarco = document.getElementById("modal-editar-barco");
    let btnCerrarModalEditar = document.getElementById(
        "btn-cerrar-modal-editar",
    );
    let btnCancelarModalEditar = document.getElementById(
        "btn-cancelar-modal-editar",
    );
    let formEditarBarco = document.getElementById("form-editar-barco");

    // Seleccionamos todos los botones editar de la tabla
    let botonesEditar = document.querySelectorAll(".btn-editar-barco");

    // Recorremos los botones con un bucle for
    for (let boton of botonesEditar) {
        //a cada botón le añadimos un evecto click
        boton.addEventListener("click", function () {
            // cuando hagamos click en un botón recogemos todos los datos de esa fila
            let id = this.getAttribute("data-id");
            let nombre = this.getAttribute("data-nombre");
            let matricula = this.getAttribute("data-matricula");
            let tipo = this.getAttribute("data-tipo");
            let eslora = this.getAttribute("data-eslora");
            let manga = this.getAttribute("data-manga");
            let calado = this.getAttribute("data-calado");

            //con estos datos rellenamos los inputs del formulario del modal
            document.getElementById("edit-nombre").value = nombre;
            document.getElementById("edit-matricula").value = matricula;
            document.getElementById("edit-tipo").value = tipo || "";
            document.getElementById("edit-eslora").value = eslora;
            document.getElementById("edit-manga").value = manga;
            document.getElementById("edit-calado").value = calado;

            // Cambiamos la URL (action) del formulario
            // para que  la función encargada de editar reciba el ID como parámetro
            formEditarBarco.action = `/mi-panel/embarcaciones/${id}`;

            // mostramos el formulario para editar
            modalEditarBarco.classList.remove("hidden");
        });
    }

    // Función para cerrar el modal de edición
    function cerrarModalEditar() {
        modalEditarBarco.classList.add("hidden");
    }

    // Asignamos los eventos para cerrar el modal de edición
    btnCerrarModalEditar.addEventListener("click", cerrarModalEditar);
    btnCancelarModalEditar.addEventListener("click", cerrarModalEditar);

    /*************************************************
     * LOGICA PARA CONFIRMAR ACCIONES DESTRUCTIVAS (CANCELAR RESERVA Y ELIMINAR BARCO)
     *****************************************************/
    // Seleccionamos todos los formularios de cancelar reserva
    //habrá tantos formularios como reservas pendientes de cancelar
    let formulariosCancelar = document.querySelectorAll(
        ".form-cancelar-reserva",
    );

    // Recorremos los formularios con un bucle for
    for (let form of formulariosCancelar) {
        // Escuchamos el evento submit por cada formulario
        form.addEventListener("submit", function (evento) {
            // Mostramos la ventana de confirmación
            let confirmar = confirm(
                "¿Seguro que quieres cancelar esta reserva?",
            );

            // si el usuario cancela detenemos el envio del formulario
            if (!confirmar) {
                evento.preventDefault();
            }
        });
    }

    // Seleccionamos todos los formularios de eliminar barco
    //habrá tantos formularios como barcos activos tenga
    let formulariosEliminar = document.querySelectorAll(".form-eliminar-barco");

    // Recorremos los formularios con un bucle for
    for (let form of formulariosEliminar) {
        // Escuchamos el evento submit por cada formulario
        form.addEventListener("submit", function (evento) {
            // Mostramos la ventana de confirmación
            let confirmar = confirm("¿Seguro que quieres eliminar este barco?");
            if (!confirmar) {
                evento.preventDefault();
            }
        });
    }
});
