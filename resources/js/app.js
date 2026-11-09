import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

// Función con la lógica del banner de cookies
document.addEventListener("DOMContentLoaded", function () {
    let banner = document.getElementById("cookie-banner");

    if (banner && !localStorage.getItem("cookie_consent")) {
        banner.classList.remove("hidden");
    }

    let btnAccept = document.getElementById("cookie-accept");
    if (btnAccept) {
        btnAccept.addEventListener("click", function () {
            localStorage.setItem("cookie_consent", "accepted");
            banner.classList.add("hidden");
        });
    }

    let btnReject = document.getElementById("cookie-reject");
    if (btnReject) {
        btnReject.addEventListener("click", function () {
            localStorage.setItem("cookie_consent", "rejected");
            banner.classList.add("hidden");
        });
    }
});

// Función con la logica del modal de ayuda
document.addEventListener("DOMContentLoaded", function () {
    let btnOpenHelp = document.getElementById("btn-open-help");
    let btnCloseHelp = document.getElementById("btn-close-help");
    let btnCloseHelpBottom = document.getElementById("btn-close-help-bottom");
    let helpModal = document.getElementById("help-modal");

    if (btnOpenHelp && helpModal) {
        // Abrir modal
        btnOpenHelp.addEventListener("click", function () {
            helpModal.classList.remove("hidden");
        });

        // Función para cerrar
        function cerrarAyuda() {
            helpModal.classList.add("hidden");
        }

        // Cerrar con la "X" o con el botón "Entendido"
        if (btnCloseHelp) btnCloseHelp.addEventListener("click", cerrarAyuda);
        if (btnCloseHelpBottom) btnCloseHelpBottom.addEventListener("click", cerrarAyuda);

        // Cerrar haciendo clic fuera del modal (en el fondo oscuro)
        helpModal.addEventListener("click", function (e) {
            if (e.target === helpModal) {
                cerrarAyuda();
            }
        });

        // Cerrar pulsando la tecla Escape
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && !helpModal.classList.contains("hidden")) {
                cerrarAyuda();
            }
        });
    }
});
