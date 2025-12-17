/* ---------------------------------------------------
   APP PRINCIPAL
--------------------------------------------------- */

import { ProyectosAPI } from "./api/proyectos.api.js";
import { PintarTableros } from "./ui/pintarTableros.js";
import { ModalCrear } from "./ui/modal.js";
import { obtenerDatosFormulario } from "./ui/helpers.js";

/* ----------------------
   Inicialización App
------------------------- */
document.addEventListener("DOMContentLoaded", async () => {
    ModalCrear.init();
    await cargarTableros();
    
});

document.addEventListener("click", (e) => {
    const boton = e.target.closest("#btnCrearTablero");

    if (!boton) return;

    console.log("✅ Click en crear tablero");
    ModalCrear.abrir();
});

//const modalEl = document.getElementById('modalCrearTablero');
//console.log('Modal encontrado:', modalEl);
//console.log('Bootstrap:', window.bootstrap);
const btn = document.getElementById('btnAbrirModalTablero');
console.log('Botón:', btn);

/* ----------------------
   Cargar tableros
------------------------- */
async function cargarTableros() {
    try {
        const respuesta = await ProyectosAPI.listar();
        const proyectos = respuesta.data;   // <- AQUÍ invocas los datos

        PintarTableros.pintarLista(proyectos);

    } catch (error) {
        console.error(error);
        alert("No se pudieron cargar los tableros.");
    }
}

/* ----------------------
   Guardar nuevo tablero
------------------------- */
document.getElementById("btnGuardarTablero").addEventListener("click", async () => {

    const datos = obtenerDatosFormulario();

    if (!datos.nombre) {
        alert("El nombre del tablero es obligatorio.");
        return;
    }

    try {
        await ProyectosAPI.crear(datos);
        await cargarTableros();
        ModalCrear.cerrar();

    } catch (error) {
        alert(error.mensaje ?? "Error al crear tablero.");
    }
});
