document.addEventListener("DOMContentLoaded", function () {
    // Procedemos a la selección de los elementos del DOM
    let tarifaBase = window.tarifaBaseReserva || 0;
    let limitesAmarre = window.limitesAmarre || { eslora: 999, manga: 999, calado: 999 };

    let inputEntrada = document.getElementById("fecha_entrada");
    let inputSalida = document.getElementById("fecha_salida");
    let selectBarco = document.getElementById("id_embarcacion");
    let serviciosSeleccionados = document.querySelectorAll(".servicio-checkbox");
    let checkTerminos = document.getElementById("acepto_terminos");
    let btnConfirmar = document.getElementById("btn-confirmar");

    // Elementos de la ficha de dimensiones del barco
    let dimEslora = document.getElementById("dim-barco-eslora");
    let dimManga = document.getElementById("dim-barco-manga");
    let dimCalado = document.getElementById("dim-barco-calado");
    let msgBarcoValido = document.getElementById("mensaje-barco-valido");
    let msgBarcoInvalido = document.getElementById("mensaje-barco-invalido");

    // Si no estamos en la página de reservas no hacemos nada
    if (!inputEntrada) return;

    // Función auxiliar para formatear cantidades en euros con coma decimal (ej: 135,00 €)
    function formatearEuros(cantidad) {
        return cantidad.toFixed(2).replace(".", ",") + " €";
    }

    // Función auxiliar para formatear la fecha con día y mes corto (ej: 22 oct)
    function formatearFechaCorta(fechaStr) {
        let f = new Date(fechaStr + "T00:00:00");
        return f.toLocaleDateString("es-ES", {
            day: "numeric",
            month: "short",
        });
    }

    // Función para validar las dimensiones de la embarcación seleccionada
    function validarEmbarcacion() {
        if (!selectBarco || !selectBarco.value) {
            if (dimEslora) dimEslora.innerText = "--";
            if (dimManga) dimManga.innerText = "--";
            if (dimCalado) dimCalado.innerText = "--";
            if (msgBarcoValido) msgBarcoValido.classList.add("hidden");
            if (msgBarcoInvalido) msgBarcoInvalido.classList.add("hidden");
            return false;
        }

        let opcion = selectBarco.options[selectBarco.selectedIndex];
        let eslora = parseFloat(opcion.dataset.eslora || 0);
        let manga = parseFloat(opcion.dataset.manga || 0);
        let calado = parseFloat(opcion.dataset.calado || 0);

        if (dimEslora) dimEslora.innerText = eslora;
        if (dimManga) dimManga.innerText = manga;
        if (dimCalado) dimCalado.innerText = calado;

        // Comprobamos si las medidas caben en los límites máximos del amarre
        let esCompatible = (
            eslora <= limitesAmarre.eslora &&
            manga <= limitesAmarre.manga &&
            calado <= limitesAmarre.calado
        );

        if (esCompatible) {
            if (msgBarcoValido) msgBarcoValido.classList.remove("hidden");
            if (msgBarcoInvalido) msgBarcoInvalido.classList.add("hidden");
        } else {
            if (msgBarcoValido) msgBarcoValido.classList.add("hidden");
            if (msgBarcoInvalido) msgBarcoInvalido.classList.remove("hidden");
        }

        return esCompatible;
    }

    // Función para realizar el cálculo total y desgloses
    function calcularTotales() {
        let dias = 0;

        // Comprobamos si el usuario ha rellenado las 2 fechas
        if (inputEntrada.value && inputSalida.value) {
            let fecha1 = new Date(inputEntrada.value + "T00:00:00");
            let fecha2 = new Date(inputSalida.value + "T00:00:00");
            
            // La resta de las fechas en JS es en milisegundos
            let diferenciaTiempo = fecha2 - fecha1;
            // Convertimos de milisegundos a días
            dias = Math.ceil(diferenciaTiempo / (1000 * 3600 * 24));

            // En el caso de que el usuario haya metido las fechas correctamente
            // mostramos el mensaje de éxito
            if (dias > 0) {
                let msgFechas = document.getElementById("mensaje-fechas");
                let txtFechas = document.getElementById("texto-fechas");
                if (msgFechas && txtFechas) {
                    msgFechas.classList.remove("hidden");
                    txtFechas.innerText = `Fechas válidas: salida posterior a la llegada · ${dias} ${dias === 1 ? 'noche disponible' : 'noches disponibles'}.`;
                }

                // Formateamos las fechas para la pastilla del resumen (ej: 22 – 25 oct 2026)
                let fEntradaTexto = formatearFechaCorta(inputEntrada.value);
                let fSalidaTexto = formatearFechaCorta(inputSalida.value);
                let anio = fecha2.getFullYear();

                let boxFechas = document.getElementById("resumen-fechas-box");
                if (boxFechas) {
                    boxFechas.classList.remove("hidden");
                    document.getElementById("resumen-fechas-texto").innerText =
                        `${fEntradaTexto} – ${fSalidaTexto} ${anio}`;
                    document.getElementById("resumen-noches-badge").innerText =
                        `${dias} ${dias === 1 ? "noche" : "noches"}`;
                }

                // Desglosamos el texto del amarre con el multiplicador de noches
                let labelAmarre = document.getElementById("resumen-amarre-label");
                if (labelAmarre) {
                    labelAmarre.innerText = `Amarre · ${formatearEuros(tarifaBase)} × ${dias} ${dias === 1 ? "noche" : "noches"}`;
                }
            } else {
                let msgFechas = document.getElementById("mensaje-fechas");
                if (msgFechas) msgFechas.classList.add("hidden");

                let boxFechas = document.getElementById("resumen-fechas-box");
                if (boxFechas) boxFechas.classList.add("hidden");

                let labelAmarre = document.getElementById("resumen-amarre-label");
                if (labelAmarre) {
                    labelAmarre.innerText = `Amarre · ${formatearEuros(tarifaBase)} × 0 noches`;
                }
                dias = 0;
            }
        } else {
            let msgFechas = document.getElementById("mensaje-fechas");
            if (msgFechas) msgFechas.classList.add("hidden");

            let boxFechas = document.getElementById("resumen-fechas-box");
            if (boxFechas) boxFechas.classList.add("hidden");

            let labelAmarre = document.getElementById("resumen-amarre-label");
            if (labelAmarre) {
                labelAmarre.innerText = `Amarre · ${formatearEuros(tarifaBase)} × 0 noches`;
            }
        }

        // Procedemos a calcular el coste del amarre
        let costeAmarre = dias * tarifaBase;
        document.getElementById("resumen-amarre").innerText = formatearEuros(costeAmarre);

        // Procedemos a calcular el coste de los servicios
        let costeServicios = 0;
        let htmlServicios = "";

        // Recorremos todos los servicios que ofrece el muelle
        for (let servicioSeleccionado of serviciosSeleccionados) {
            // Comprobamos uno a uno si ha sido seleccionado
            if (servicioSeleccionado.checked) {
                let precio = parseFloat(servicioSeleccionado.getAttribute("data-precio") || 0);
                let nombre = servicioSeleccionado.getAttribute("data-nombre");
                let tipo = servicioSeleccionado.getAttribute("data-tipo") || "noche";

                // Si es por noche multiplicamos por días (o 1 si aún no ha seleccionado fechas)
                let multiplicador = tipo === "estancia" ? 1 : (dias > 0 ? dias : 1);
                let subtotalServicio = precio * multiplicador;
                costeServicios += subtotalServicio;

                // Desglosamos el texto del servicio: Nombre · Precio € × N noches
                let detalleCobro = tipo === "estancia"
                    ? `(por estancia)`
                    : `× ${multiplicador} ${multiplicador === 1 ? "noche" : "noches"}`;

                htmlServicios += `
                    <div class="flex justify-between items-center text-xs text-slate-600">
                        <span>${nombre} · ${formatearEuros(precio)} ${detalleCobro}</span>
                        <span class="font-semibold text-slate-800">${formatearEuros(subtotalServicio)}</span>
                    </div>
                `;
            }
        }

        // Todos los div acumulados los pintamos de un solo golpe
        document.getElementById("contenedor-servicios-resumen").innerHTML = htmlServicios;

        // Procedemos a calcular el coste total con desglose de IVA (21%)
        let subtotal = costeAmarre + costeServicios;
        let iva = subtotal * 0.21;
        let total = subtotal + iva;

        document.getElementById("resumen-subtotal").innerText = formatearEuros(subtotal);
        document.getElementById("resumen-iva").innerText = formatearEuros(iva);
        document.getElementById("resumen-total").innerText = formatearEuros(total);
    }

    // Validar botón de envío y requisitos
    function validarBoton() {
        let barcoValido = validarEmbarcacion();
        let fechasValidas = (
            inputEntrada.value &&
            inputSalida.value &&
            (new Date(inputSalida.value + "T00:00:00") > new Date(inputEntrada.value + "T00:00:00"))
        );

        let mensajeListo = document.getElementById("mensaje-listo-confirmar");

        // Si el usuario ha cumplido todos los campos requeridos y aceptado términos
        if (fechasValidas && barcoValido && checkTerminos.checked) {
            btnConfirmar.disabled = false;
            btnConfirmar.classList.remove("opacity-50", "cursor-not-allowed");
            if (mensajeListo) mensajeListo.classList.remove("hidden");
        } else {
            btnConfirmar.disabled = true;
            btnConfirmar.classList.add("opacity-50", "cursor-not-allowed");
            if (mensajeListo) mensajeListo.classList.add("hidden");
        }
    }

    // El evento change e input lo usamos para verificar cambios en el formulario de reservas
    inputEntrada.addEventListener("change", () => {
        calcularTotales();
        validarBoton();
    });
    inputSalida.addEventListener("change", () => {
        calcularTotales();
        validarBoton();
    });
    selectBarco.addEventListener("change", () => {
        validarEmbarcacion();
        validarBoton();
    });
    checkTerminos.addEventListener("change", validarBoton);

    for (let servicioSeleccionado of serviciosSeleccionados) {
        servicioSeleccionado.addEventListener("change", calcularTotales);
    }

    // Inicializar por si acaso hay datos precargados (old input de Laravel al regresar de error)
    validarEmbarcacion();
    calcularTotales();
    validarBoton();
});