const API_URL = "http://127.0.0.1:8000/api/v1/proyectos";

/**
 * Obtener todos los proyectos
 */
export async function getProyectos() {
  const response = await fetch(API_URL);
  if (!response.ok) {
    throw new Error("Error al obtener proyectos");
  }
  return await response.json();
}

/**
 * Obtener un proyecto por ID
 */
export async function getProyectoById(id) {
  const response = await fetch(`${API_URL}/${id}`);
  if (!response.ok) {
    throw new Error("Error al obtener el proyecto");
  }
  return await response.json();
}

/**
 * Crear un nuevo proyecto
 */
export async function createProyecto(data) {
  const response = await fetch(API_URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });

  if (!response.ok) {
    throw new Error("Error al crear proyecto");
  }

  return await response.json();
}

/**
 * Actualizar proyecto
 */
export async function updateProyecto(id, data) {
  const response = await fetch(`${API_URL}/${id}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });

  if (!response.ok) {
    throw new Error("Error al actualizar proyecto");
  }

  return await response.json();
}

/**
 * Eliminar proyecto
 */
export async function deleteProyecto(id) {
  const response = await fetch(`${API_URL}/${id}`, {
    method: "DELETE",
  });

  if (!response.ok) {
    throw new Error("Error al eliminar proyecto");
  }

  return true;
}

/**
 * Buscar proyectos
 */
export async function buscarProyectos(texto) {
  const response = await fetch(
    `${API_URL}/buscar?texto=${encodeURIComponent(texto)}`
  );

  if (!response.ok) {
    throw new Error("Error al buscar proyectos");
  }

  return await response.json();
}

/**
 * Filtrar proyectos
 */
export async function filtrarProyectos({ id_estado_proyecto, id_equipo }) {
  const params = new URLSearchParams();

  if (id_estado_proyecto)
    params.append("id_estado_proyecto", id_estado_proyecto);
  if (id_equipo) params.append("id_equipo", id_equipo);

  const response = await fetch(`${API_URL}/filtrar?${params.toString()}`);

  if (!response.ok) {
    throw new Error("Error al filtrar proyectos");
  }

  return await response.json();
}
