import { limpiarFormulario } from "./helpers.js";

export const ModalCrear = {

    instancia: null,

    init() {
        const modalEl = document.getElementById("modalCrearTablero");
        this.instancia = new bootstrap.Modal(modalEl);
    },

    abrir() {
        limpiarFormulario();
        this.instancia?.show();
    },

    cerrar() {
        this.instancia?.hide();
    }
};

