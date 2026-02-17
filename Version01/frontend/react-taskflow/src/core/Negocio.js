// core/NegocioProyectos.js

const API_BASE = "http://127.0.0.1:8000/api/v1";
const PROYECTOS_URL = `${API_BASE}/proyectos`;
const TAREAS_URL = `${API_BASE}/tareas`;

const Negocio = (function () {
  // Métodos para Proyectos
  async function obtenerProyectos() {
    const res = await fetch(PROYECTOS_URL);

    if (!res.ok) {
      throw new Error("Error al obtener proyectos");
    }

    return await res.json();
  }

  async function obtenerProyecto(id) {
    const res = await fetch(`${PROYECTOS_URL}/${id}`);

    if (!res.ok) {
      throw new Error("Error al obtener proyecto");
    }

    return await res.json();
  }

  async function crearProyecto(data) {
    const res = await fetch(PROYECTOS_URL, {
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
    const res = await fetch(`${PROYECTOS_URL}/${id}`, {
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
    const res = await fetch(`${PROYECTOS_URL}/${id}`, {
      method: "DELETE",
    });

    if (!res.ok) {
      throw new Error("Error al eliminar proyecto");
    }

    return true;
  }

  // Métodos para Tareas

  async function obtenerTareas() {
    const res = await fetch(TAREAS_URL);
    if (!res.ok) {
      throw new Error("Error al obtener tareas");
    }
    return await res.json();
  }

  async function obtenerTarea(id) {
    const res = await fetch(`${TAREAS_URL}/${id}`);
    if (!res.ok) {
      throw new Error("Error al obtener tarea");
    }
    return await res.json();
  }

  async function crearTarea(data) {
    const res = await fetch(TAREAS_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    if (!res.ok) {
      throw new Error("Error al crear tarea");
    }
    return await res.json();
  }

  async function actualizarTarea(id, data) {
    const res = await fetch(`${TAREAS_URL}/${id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    if (!res.ok) {
      throw new Error("Error al actualizar tarea");
    }
    return await res.json();
  }

  async function eliminarTarea(id) {
    const res = await fetch(`${TAREAS_URL}/${id}`, {
      method: "DELETE",
    });
    if (!res.ok) {
      throw new Error("Error al eliminar tarea");
    }
    return true;
  }

  return {
    // Proyectos
    obtenerProyectos,
    obtenerProyecto,
    crearProyecto,
    actualizarProyecto,
    eliminarProyecto,
    // Tareas
    obtenerTareas,
    obtenerTarea,
    crearTarea,
    actualizarTarea,
    eliminarTarea,
  };
})();

export default Negocio;
