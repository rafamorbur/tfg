//***************
//PINTAMOS EL MAPA
//********* ******
// El mapa se inicia centrao en malaga por defecto y sin el control de zoom
let map = L.map("map", { zoomControl: false }).setView([36.65, -4.55], 11);
L.control.zoom({ position: "bottomright" }).addTo(map);

// Definimos la capa calle
let capaCalles = L.tileLayer(
    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    {
        maxZoom: 19,
        attribution: "© OpenStreetMap",
    },
);

//definimos la capa satelite
let capaSatelite = L.tileLayer(
    "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
    {
        maxZoom: 19,
        attribution: "Tiles &copy; Esri",
    },
);

capaCalles.addTo(map);

// Grupo de marcadores para los pantalanes en el mapa
let grupoPantalanes = L.layerGroup().addTo(map);

// Objeto para guardar los pines de los muelles y poder manipularlos luego
let marcadoresMuelles = {};

// Recibimos los muelles desde la variable global que le pasaremos desde Blade
let muelles = window.muellesData || [];

//***************
//FUNCIONES DE UTILIDAD Y CONTROL DEL MAPA
//***************
// Funcion que usaremos para formatear las coordenadas geográficas
//Transformamso las coordenadas decimales en grados minutos y segundos
function formatearCoordenadas(lat, lng) {
    let latGrad = Math.floor(Math.abs(lat));
    let latMin = Math.round((Math.abs(lat) - latGrad) * 60);
    let latHem = lat >= 0 ? "N" : "S";
    let lngGrad = Math.floor(Math.abs(lng));
    let lngMin = Math.round((Math.abs(lng) - lngGrad) * 60);
    let lngHem = lng >= 0 ? "E" : "O";
    return `${latGrad}°${latMin}' ${latHem} ${lngGrad}°${lngMin}' ${lngHem}`;
}

//Creamos una función para cambiar de capas
function cambiarCapa(tipo) {
    if (tipo === "satelite") {
        if (map.hasLayer(capaCalles)) map.removeLayer(capaCalles);
        capaSatelite.addTo(map);
        btnSatelite.classList.add("bg-teal-800", "text-white");
        btnSatelite.classList.remove("text-slate-600");
        btnCalles.classList.remove("bg-teal-800", "text-white");
        btnCalles.classList.add("text-slate-600");
    } else {
        if (map.hasLayer(capaSatelite)) map.removeLayer(capaSatelite);
        capaCalles.addTo(map);
        btnCalles.classList.add("bg-teal-800", "text-white");
        btnCalles.classList.remove("text-slate-600");
        btnSatelite.classList.remove("bg-teal-800", "text-white");
        btnSatelite.classList.add("text-slate-600");
    }
}

// Creamos una funcion para volver al mapa central
function volverMapaCentral() {
    //devuelve la camara al centro del mapa
    map.flyTo([36.65, -4.55], 11, { duration: 1.2 });

    //oculta los carteles flotantes
    document.getElementById("card-puerto-mapa").classList.add("hidden");
    document.getElementById("btn-volver-mapa").classList.add("hidden");
    document.getElementById("badge-coordenadas").classList.add("hidden");

    // Borramos las burbujas que flotaban sobre el agua
    grupoPantalanes.clearLayers();

    // vuele otra vez el mapa calle
    cambiarCapa("calles");

    // Reseteamos el panel derecho al panel de parking
    pintarPanelParking();
}

//***************
// EVENTOS DE LOS BOTONES DEL MAPA
//***************
// Seleccionamos los botones de la vista
let btnCalles = document.getElementById("btn-capa-calles");
let btnSatelite = document.getElementById("btn-capa-satelite");

//le asignamos el evento al botón cada vez uqe hacemos click sobre el
//conseguimos cambiar de vision mapa a calle y viceversa
btnCalles.addEventListener("click", function () {
    cambiarCapa("calles");
});

btnSatelite.addEventListener("click", function () {
    cambiarCapa("satelite");
});

// Asignamos la función al botón
document
    .getElementById("btn-volver-mapa")
    .addEventListener("click", volverMapaCentral);

//***************
// CREACIÓN DE PINES Y PANEL DE DETALLES
//***************
//Una vez obtenido los muelles los recorremos uno a uno
for (let muelle of muelles) {
    if (muelle.latitud && muelle.longitud) {
        //haciendo uso de la libreria Leaftet creamos el marcador y lo añadimos al mapa
        //según las coordenadas uqe le hemos pasado antes
        let pin = L.marker([muelle.latitud, muelle.longitud]).addTo(map);

        // este pin lo guardamos para despues usando su Id para la lógica de filtros
        marcadoresMuelles[muelle.id_muelle] = pin;

        //le añadimos un cartelito al pin de cada puerto con su nombre
        pin.bindPopup(`<b>${muelle.nombre}</b><br>${muelle.localidad}`);

        //A cada pin le asignamos una acción click
        pin.on("click", function () {
            //cuando hacemos click comienza una acción vista de pájaro haciendo zoom al puerto
            map.flyTo([muelle.latitud, muelle.longitud], 17, { duration: 1.4 });

            // Cambiamos a la capa satelite
            cambiarCapa("satelite");

            // Mostramos la tarjeta del puerto (esquina superior izquierda)
            //mostramos el nombre
            document.getElementById("mapa-puerto-nombre").innerText =
                muelle.nombre;
            //mostramos las corrdenadas
            document.getElementById("mapa-puerto-ubicacion").innerText =
                `${muelle.localidad}, ${muelle.provincia}`;
            document
                .getElementById("card-puerto-mapa")
                .classList.remove("hidden");

            // Mostramos las coordenadas y el botón de volver
            document
                .getElementById("badge-coordenadas")
                .classList.remove("hidden");
            document.getElementById("mapa-coordenadas-texto").innerText =
                formatearCoordenadas(muelle.latitud, muelle.longitud);
            document
                .getElementById("btn-volver-mapa")
                .classList.remove("hidden");

            //En el panel derecho de los detalles mostramos un spinner
            let panel = document.getElementById("panel-detalles");
            panel.innerHTML = `
                <div class="flex flex-col items-center justify-center mt-20 text-slate-400">
                    <div class="w-8 h-8 border-4 border-teal-800 border-t-transparent rounded-full animate-spin mb-4"></div>
                    <span class="text-sm">Cargando información...</span>
                </div>
            `;

            // hacemos una petición fetch para obtener los datos del muelle
            fetch(`/api/muelle/${muelle.id_muelle}`)
                //comprobamos si la promesa ha sido exitosa
                .then((respuesta) => {
                    if (!respuesta.ok)
                        throw new Error(
                            "Error al obtener los datos del muelle",
                        );
                    return respuesta.json();
                })
                .then((datos) => {
                    // Limpiamos las burbujas anteriores si había un muelle seleccionado
                    grupoPantalanes.clearLayers();
                    let amarresHTML = "";

                    //se ejecuta el codigo si amarres existe y es mayor a cero
                    if (datos.amarres && datos.amarres.length > 0) {
                        //recorre el array; usamos reduce para agrupar los amarres por letras A,B,C
                        let pantalanes = datos.amarres.reduce(
                            (acumulador, amarre) => {
                                let letra = amarre.numero.charAt(0);
                                if (!acumulador[letra]) {
                                    acumulador[letra] = [];
                                }
                                acumulador[letra].push(amarre);
                                return acumulador;
                            },
                            {},
                        );

                        // Desplazamientos para situar las burbujas de los pantalanes sobre el agua del puerto
                        //asi evitamos un solapamiento
                        let offsets = [
                            [-0.0007, -0.001],
                            [0.0001, -0.0004],
                            [0.0009, 0.0008],
                            [-0.0008, 0.0007],
                            [0.0005, -0.0012],
                        ];

                        //los amarres han sido acumulados asi { "A": [amarre1, amarre2], "B": [amarre3] }.
                        let index = 0;

                        for (let [letra, amarresDelPantalan] of Object.entries(
                            pantalanes,
                        )) {
                            //de todos los amarres que tiene un pantalan
                            let total = amarresDelPantalan.length;
                            //nos quedamos solo con los disponibles
                            // CAMBIO AQUÍ: Usamos estado_visual
                            let libres = amarresDelPantalan.filter(
                                (a) => a.estado_visual === "disponible",
                            ).length;

                            // Marcador burbuja
                            let offset = offsets[index % offsets.length];
                            let posLat = parseFloat(muelle.latitud) + offset[0];
                            let posLng =
                                parseFloat(muelle.longitud) + offset[1];

                            //creando la burbuja personalizada en el html
                            let badgeHtml = `
                                <div class="cursor-pointer group flex items-center gap-2 bg-white/95 hover:bg-teal-900 hover:text-white backdrop-blur-md shadow-xl border border-slate-200/90 rounded-2xl px-3 py-1.5 transition-all transform hover:scale-110 whitespace-nowrap">
                                    <span class="font-black text-sm">${letra}</span>
                                    <span class="w-2.5 h-2.5 rounded-full ${libres > 0 ? "bg-emerald-500" : "bg-red-500"}"></span>
                                    <span class="text-xs text-slate-600 group-hover:text-teal-100 font-bold">${libres}/${total} libres</span>
                                </div>
                            `;
                            //sustituyendo la chincheta azul por defecto por esta burbuja creada
                            let customIcon = L.divIcon({
                                className: "custom-pantalan-badge",
                                html: badgeHtml,
                                iconSize: [120, 36],
                                iconAnchor: [60, 18],
                            });

                            //pintamos la burbuja en el mapa usando las coordenadas desplazadas
                            let marcadorPantalan = L.marker([posLat, posLng], {
                                icon: customIcon,
                            }).addTo(grupoPantalanes);

                            // Al hacer clic en el badge del mapa, resalta el pantalán en el panel
                            marcadorPantalan.on("click", function () {
                                let bloque = document.getElementById(
                                    `pantalan-bloque-${letra}`,
                                );
                                if (bloque) {
                                    bloque.scrollIntoView({
                                        behavior: "smooth",
                                        block: "center",
                                    });
                                    bloque.classList.add(
                                        "ring-2",
                                        "ring-teal-600",
                                    );
                                    setTimeout(
                                        () =>
                                            bloque.classList.remove(
                                                "ring-2",
                                                "ring-teal-600",
                                            ),
                                        1500,
                                    );
                                }
                            });

                            index++;

                            // construimos el html visual del panel de la derecha
                            amarresHTML += `
                                <div id="pantalan-bloque-${letra}" class="mb-5 bg-slate-100 border border-slate-200 rounded-xl p-4 transition-all">
                                    <h4 class="font-bold text-slate-700 mb-3 text-sm flex items-center justify-between">
                                        <span class="bg-teal-800 text-white px-2.5 py-0.5 rounded-md text-xs font-semibold">Pantalán ${letra}</span>
                                        <span class="text-xs text-slate-500 font-semibold">${libres} libres de ${total}</span>
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                            `;

                            //recorremos cada amarre de cada pantalan y le asignamos un color
                            for (let amarre of amarresDelPantalan) {
                                let color = "";
                                // CAMBIO AQUÍ: Usamos estado_visual
                                if (amarre.estado_visual === "disponible") {
                                    color =
                                        "bg-emerald-500 hover:bg-emerald-600 cursor-pointer hover:scale-105";
                                } else if (amarre.estado_visual === "ocupado") {
                                    color =
                                        "bg-red-500 opacity-50 cursor-not-allowed";
                                } else {
                                    color =
                                        "bg-amber-500 opacity-50 cursor-not-allowed";
                                }
                                //acumulamos la información de cada amarre
                                // CAMBIO AQUÍ: Usamos estado_visual en el title
                                amarresHTML += `
                                <div id="amarre-${amarre.id_amarre}" 
                                    data-id="${amarre.id_amarre}" 
                                    class="amarre-seleccionable w-14 h-12 ${color} text-white flex flex-col items-center justify-center rounded-md shadow-sm transition-all text-xs font-bold" 
                                    title="${amarre.estado_visual} - Eslora: ${amarre.eslora_max}m">
                                    <span>${amarre.numero}</span>
                                </div>
                            `;
                            }

                            amarresHTML += `
                                    </div>
                                </div>
                            `;
                        }
                    } else {
                        amarresHTML = `<p class="text-xs text-slate-400 italic">No hay amarres dados de alta en este muelle.</p>`;
                    }

                    //finalmente pintamos la información acumulada de cada amarre
                    panel.innerHTML = `
                        <div class="animate-fade-in">
                            <h2 class="text-2xl font-bold text-slate-800 mb-1">${datos.nombre}</h2>
                            <p class="text-sm text-slate-500 mb-4 flex items-center gap-1">
                                📍 ${datos.localidad} (${datos.provincia})
                            </p>
                            
                            <div class="mb-6">
                                <h3 class="font-semibold text-slate-700 mb-3 text-sm">Plano de pantalanes</h3>
                                <div class="overflow-y-auto max-h-96 pr-1 space-y-2">
                                    ${amarresHTML}
                                </div>
                                
                                <div class="flex gap-4 mt-4 text-xs text-slate-500">
                                    <div class="flex items-center gap-1"><span class="w-3 h-3 bg-emerald-500 rounded-sm"></span> Libre</div>
                                    <div class="flex items-center gap-1"><span class="w-3 h-3 bg-red-500 rounded-sm"></span> Ocupado</div>
                                    <div class="flex items-center gap-1"><span class="w-3 h-3 bg-amber-500 rounded-sm"></span> Reparación</div>
                                </div>
                            </div>

                            <!-- NUEVO: Contenedor para el mensaje de error, oculto por defecto -->
                            <div id="mensaje-error-reserva" class="hidden mb-3 bg-red-50 border border-red-200 text-red-600 text-sm p-3 rounded-lg flex items-center gap-2">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span id="texto-error-reserva"></span>
                            </div>

                            <button id="btn-iniciar-reserva" class="w-full bg-teal-800 text-white py-3 rounded-md hover:bg-teal-700 transition shadow-md font-semibold">
                                Hacer Reserva
                            </button>
                        </div>
                    `;

                    // Lógica para seleccionar un amarre verde
                    let amarresSeleccionables = document.querySelectorAll(
                        ".amarre-seleccionable",
                    );
                    for (let divAmarre of amarresSeleccionables) {
                        divAmarre.addEventListener("click", function () {
                            // Solo dejamos seleccionar si el amarre está disponible (verde)
                            if (this.classList.contains("bg-emerald-500")) {
                                // 1. Quitamos la selección de cualquier otro amarre
                                let todosLosAmarres = document.querySelectorAll(
                                    ".amarre-seleccionable",
                                );
                                for (let a of todosLosAmarres) {
                                    a.classList.remove(
                                        "ring-4",
                                        "ring-white",
                                        "ring-offset-2",
                                        "scale-110",
                                    );
                                }

                                // 2. Marcamos este amarre visualmente
                                this.classList.add(
                                    "ring-4",
                                    "ring-white",
                                    "ring-offset-2",
                                    "scale-110",
                                );

                                // 3. Guardamos el ID del amarre en una variable global
                                window.amarreSeleccionadoId =
                                    this.getAttribute("data-id");

                                // 4. Cambiamos el texto del botón para que quede claro
                                let btnReserva = document.querySelector(
                                    "#panel-detalles button",
                                );
                                btnReserva.innerHTML = `Reservar Amarre ${this.innerText}`;
                                btnReserva.classList.remove(
                                    "bg-teal-800",
                                    "hover:bg-teal-700",
                                );
                                btnReserva.classList.add(
                                    "bg-emerald-600",
                                    "hover:bg-emerald-700",
                                    "animate-pulse",
                                );

                                // 5. Ocultamos el mensaje de error si estaba visible
                                document
                                    .getElementById("mensaje-error-reserva")
                                    .classList.add("hidden");
                            }
                        });
                    }

                    // Lógica del botón de reservar
                    document
                        .getElementById("btn-iniciar-reserva")
                        .addEventListener("click", function () {
                            let divError = document.getElementById(
                                "mensaje-error-reserva",
                            );
                            let textoError = document.getElementById(
                                "texto-error-reserva",
                            );

                            if (window.amarreSeleccionadoId) {
                                // Si hay un amarre seleccionado le redirigimos al panel de seserva
                                window.location.href = `/reservar/${window.amarreSeleccionadoId}`;
                            } else {
                                // Si NO hay amarre, mostramos un mensaje de error elegante
                                textoError.innerText =
                                    "Por favor, selecciona un amarre verde en el plano antes de reservar.";
                                divError.classList.remove("hidden");

                                // Ocultamos el mensaje automáticamente después de 3 segundos
                                setTimeout(() => {
                                    divError.classList.add("hidden");
                                }, 3000);
                            }
                        });
                })
                .catch((error) => {
                    console.error("Error:", error);
                    panel.innerHTML = `
                        <div class="text-center text-red-500 mt-20">
                            <p class="font-semibold">⚠️ No se pudo cargar el muelle</p>
                            <p class="text-xs text-slate-400 mt-1">Comprueba la conexión con el servidor.</p>
                        </div>
                    `;
                });
        });
    }
}

//***************
// LÓGICA DE FILTROS
//***************
// Creamos una funcion para filtrar
function filtrarBusqueda() {
    // Seleciconamos los elementos del htmal y guardamos los valores
    let fechaEntrada = document.getElementById("filtro-fecha-entrada").value;
    let fechaSalida = document.getElementById("filtro-fecha-salida").value;
    let eslora =
        parseFloat(document.getElementById("filtro-eslora").value) || 0;
    let manga = parseFloat(document.getElementById("filtro-manga").value) || 0;
    let calado =
        parseFloat(document.getElementById("filtro-calado").value) || 0;

    //Un array para mostrar los errores
    let errores = [];
    let hoy = new Date();
    // Ponemos la hora a 0 para comparar solo fechas
    hoy.setHours(0, 0, 0, 0);

    // Realizamos las validaciones
    if (fechaEntrada && new Date(fechaEntrada) < hoy) {
        errores.push("La fecha de entrada no puede ser anterior a hoy.");
    }
    if (fechaSalida && new Date(fechaSalida) < hoy) {
        errores.push("La fecha de salida no puede ser anterior a hoy.");
    }
    if (
        fechaEntrada &&
        fechaSalida &&
        new Date(fechaSalida) <= new Date(fechaEntrada)
    ) {
        errores.push("La fecha de salida debe ser posterior a la de entrada.");
    }
    if (eslora < 0 || manga < 0 || calado < 0) {
        errores.push("Las dimensiones no pueden ser negativas.");
    }

    // seleccionamos los div que usaremos para mostrar los errores
    let divErrores = document.getElementById("filtro-errores");
    let listaErrores = document.getElementById("lista-errores");

    if (errores.length > 0) {
        // Mostramos los errores
        listaErrores.innerHTML = errores.map((e) => `<li>${e}</li>`).join("");
        divErrores.classList.remove("hidden");
    } else {
        // Ocultamos errores y hacemos la petición al backend
        divErrores.classList.add("hidden");
        aplicarFiltrosBackend(fechaEntrada, fechaSalida, eslora, manga, calado);
    }
}

// Función para enviar los datos a Laravel
function aplicarFiltrosBackend(
    fechaEntrada,
    fechaSalida,
    eslora,
    manga,
    calado,
) {
    // Mostramos estado de carga en el texto
    let textoResultados = document.getElementById("texto-resultados");
    textoResultados.innerHTML = "Buscando amarres...";

    // Hacemos la petición fetch
    fetch(
        //los datos escritos por el usuario van en la url
        `/api/filtrar-amarres?fecha_entrada=${fechaEntrada}&fecha_salida=${fechaSalida}&eslora=${eslora}&manga=${manga}&calado=${calado}`,
    )
        //Las respuestas (promesas) del servidor
        .then((res) => res.json())
        .then((data) => {
            // {  "total_muelles_compatibles": 3,"muelles_compatibles": [1, 3, 5]}
            //pintamos el texto con los datos que hemos recibido
            textoResultados.innerHTML = `${data.total_muelles_compatibles} de ${muelles.length} muelles con amarres compatibles`;

            // Recorremos todos puertos del mapa
            for (let muelle of muelles) {
                //buscamos si el pin esta dentro del total de muelles compatibles
                let pin = marcadoresMuelles[muelle.id_muelle];
                if (pin) {
                    //si esta incluido opacidad al maximo
                    if (data.muelles_compatibles.includes(muelle.id_muelle)) {
                        pin.setOpacity(1);
                        pin.setZIndexOffset(1000);
                    } else {
                        pin.setOpacity(0.2);
                        pin.setZIndexOffset(0);
                    }
                }
            }
        })
        .catch((err) => {
            console.error(err);
            textoResultados.innerHTML = "Error al buscar";
        });
}

// Creamos una función para limpiar los filtros
function limpiarFiltros() {
    // Limpiamos los inputs
    document.getElementById("filtro-fecha-entrada").value = "";
    document.getElementById("filtro-fecha-salida").value = "";
    document.getElementById("filtro-eslora").value = "";
    document.getElementById("filtro-manga").value = "";
    document.getElementById("filtro-calado").value = "";

    // Ocultamos errores
    document.getElementById("filtro-errores").classList.add("hidden");

    // Restauramos el texto de resultados
    let textoResultados = document.getElementById("texto-resultados");
    textoResultados.innerHTML = `${muelles.length} de ${muelles.length} muelles con amarres compatibles`;

    // Restauramos todos los pines a su estado original
    for (let id in marcadoresMuelles) {
        let pin = marcadoresMuelles[id];
        pin.setOpacity(1);
        pin.setZIndexOffset(0);
    }

    // Cerramos cualquier panel de muelle abierto
    volverMapaCentral();
}

// Asignamos las funciones a los botones
document
    .getElementById("btn-aplicar-filtros")
    .addEventListener("click", filtrarBusqueda);
document
    .getElementById("btn-limpiar-filtros")
    .addEventListener("click", limpiarFiltros);

//***************
// PANEL TIPO PARKING (VISTA GLOBAL)
//***************
// --- FUNCIÓN PARA PINTAR EL PANEL TIPO PARKING ---
function pintarPanelParking() {
    let panel = document.getElementById("panel-detalles");
    let html = `
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-1">Estado de los Puertos</h2>
            <p class="text-sm text-slate-500 mb-6">Vista global de ocupación en tiempo real</p>
        </div>
        <div class="space-y-4">
    `;

    // Recorremos todos los muelles
    for (let muelle of muelles) {
        //Si la propiedad muelles contamos, en caso contrario es 0
        let totalAmarres = muelle.amarres ? muelle.amarres.length : 0;
        let amarresLibres = 0;

        //si tiene amarres nos quedamos solo que estén disponibles
        if (totalAmarres > 0) {
            // CAMBIO AQUÍ: Usamos estado_visual
            amarresLibres = muelle.amarres.filter(
                (a) => a.estado_visual === "disponible",
            ).length;
        }

        // Calculamos el porcentaje de ocupación para la barra
        let porcentajeOcupacion =
            totalAmarres > 0
                ? ((totalAmarres - amarresLibres) / totalAmarres) * 100
                : 100; //si no tiene amarres libre consideramos que el 100% están ocupados

        // Determinamos el color de la barra según la ocupación
        let colorBarra = "bg-emerald-500"; // Verde por defecto
        if (porcentajeOcupacion > 50) colorBarra = "bg-amber-500"; // Amarillo si está medio lleno
        if (porcentajeOcupacion > 85) colorBarra = "bg-red-500"; // Rojo si está casi lleno

        // Generamos el HTML de cada fila del parking

        html += `
            <div class="tarjeta-muelle bg-slate-50 border border-slate-200 rounded-xl p-4 cursor-pointer hover:border-teal-500 transition" data-id="${muelle.id_muelle}">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold text-slate-800 text-sm">${muelle.nombre}</h3>
                    <span class="text-xs font-semibold text-slate-600">${amarresLibres} / ${totalAmarres} libres</span>
                </div>
                
                <!-- Barra de progreso tipo parking -->
                <div class="w-full bg-slate-200 rounded-full h-2.5">
                    <div class="${colorBarra} h-2.5 rounded-full" style="width: ${porcentajeOcupacion}%"></div>
                </div>
                
                <div class="flex justify-between items-center mt-2">
                    <span class="text-[10px] text-slate-500 uppercase tracking-wider">${muelle.localidad}</span>
                    <span class="text-[10px] text-slate-500 uppercase tracking-wider">${porcentajeOcupacion.toFixed(0)}% Ocupado</span>
                </div>
            </div>
        `;
    }

    html += `</div>`;
    panel.innerHTML = html;

    // Añadimos el evento clic a cada tarjeta generada
    let tarjetas = document.querySelectorAll(".tarjeta-muelle");
    for (let tarjeta of tarjetas) {
        tarjeta.addEventListener("click", function () {
            // Sacamos el ID del atributo data-id y lo convertimos a número
            let idMuelle = parseInt(this.getAttribute("data-id"));
            seleccionarMuelleDesdePanel(idMuelle);
        });
    }
}

// Función para cuando se hace clic en una tarjeta del panel tipo parking
function seleccionarMuelleDesdePanel(idMuelle) {
    // Buscamos el muelle en el array global
    // Buscamos el muelle en el array global (asegurando comparar números)
    let muelleSeleccionado = muelles.find((m) => m.id_muelle === idMuelle);

    if (muelleSeleccionado) {
        // Hacemos que el mapa vuele hacia él
        map.flyTo(
            [muelleSeleccionado.latitud, muelleSeleccionado.longitud],
            17,
            { duration: 1.4 },
        );
        cambiarCapa("satelite");

        // Actualizamos los carteles flotantes
        document.getElementById("mapa-puerto-nombre").innerText =
            muelleSeleccionado.nombre;
        document.getElementById("mapa-puerto-ubicacion").innerText =
            `${muelleSeleccionado.localidad}, ${muelleSeleccionado.provincia}`;
        document.getElementById("card-puerto-mapa").classList.remove("hidden");
        document.getElementById("badge-coordenadas").classList.remove("hidden");
        document.getElementById("mapa-coordenadas-texto").innerText =
            formatearCoordenadas(
                muelleSeleccionado.latitud,
                muelleSeleccionado.longitud,
            );
        document.getElementById("btn-volver-mapa").classList.remove("hidden");

        // Simulamos el click en el pin para que se cargue la vista detallada
        if (marcadoresMuelles[idMuelle]) {
            marcadoresMuelles[idMuelle].fire("click");
        }
    }
}

// Al cargar la página, mostramos el panel global
pintarPanelParking();
