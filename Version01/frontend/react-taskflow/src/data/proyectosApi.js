// core/NegocioProyectos.js

const negocioProyectos = (function () {
  const URL = "http://127.0.0.1:8000/api/v1/proyectos";

  async function obtenerProyectos() {
    const res = await fetch(URL);

    if (!res.ok) {
      throw new Error("Error al obtener proyectos");
    }

    return await res.json();
  }

  async function obtenerProyecto(id) {
    const res = await fetch(`${URL}/${id}`);

    if (!res.ok) {
      throw new Error("Error al obtener proyecto");
    }

    return await res.json();
  }

  async function crearProyecto(data) {
    const res = await fetch(URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    if (!res.ok) {
      throw new Error("Error al crear proyecto");
    }

    return await res.json();
  }

  async function actualizarProyecto(id, data) {
    const res = await fetch(`${URL}/${id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    if (!res.ok) {
      throw new Error("Error al actualizar proyecto");
    }

    return await res.json();
  }

  async function eliminarProyecto(id) {
    const res = await fetch(`${URL}/${id}`, {
      method: "DELETE",
    });

    if (!res.ok) {
      throw new Error("Error al eliminar proyecto");
    }

    return true;
  }

  return {
    obtenerProyectos,
    obtenerProyecto,
    crearProyecto,
    actualizarProyecto,
    eliminarProyecto,
  };
})();

export default negocioProyectos;
