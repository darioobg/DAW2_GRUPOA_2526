/* ------------------------------------------
   HELPERS GENERALES PARA UI Y FORMULARIOS
------------------------------------------- */

// recoge los datos del modal
export function obtenerDatosFormulario() {
    return {
        nombre: document.getElementById("nombreTablero").value.trim(),
        color: document.getElementById("colorFondo").value.trim(),
        equipo: document.getElementById("equipoTablero").value.trim()
    };
}

// limpia formulario del modal
export function limpiarFormulario() {
    document.getElementById("nombreTablero").value = "";
    document.getElementById("colorFondo").value = "#0c6bf2";
    document.getElementById("equipoTablero").value = "";
}

// recorta nombres largos
export function recortar(texto) {
    return texto.length > 18 ? texto.slice(0, 18) + "..." : texto;
}

// convierte fechas
export function formatearFecha(fecha) {
    if (!fecha) return "";
    const f = new Date(fecha);
    return f.toLocaleDateString("es-ES", { day: "numeric", month: "short", year: "numeric" });
}
