/* ---------------------------------------------------
   API: Proyectos (Tableros)
--------------------------------------------------- */

const API_BASE = "http://127.0.0.1:8000/api/proyectos";

export const ProyectosAPI = {

    async listar() {
        try {
            const res = await fetch(API_BASE);
            const json = await res.json();

            if (!json.ok) throw json;

            return json; // { ok:true, data:[...] }

        } catch (error) {
            console.error("Error en listar proyectos:", error);
            throw { mensaje: "No se pudo cargar la lista de tableros." };
        }
    },

    async crear(datos) {
        try {
            const res = await fetch(API_BASE, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(datos)
            });

            const json = await res.json();

            if (!res.ok) throw json;

            return json;

        } catch (error) {
            console.error("Error al crear tablero:", error);
            throw { mensaje: error?.message ?? "No se pudo crear el tablero." };
        }
    }
};
