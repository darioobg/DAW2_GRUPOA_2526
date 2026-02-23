const API_BASE = "http://127.0.0.1:8000/api/v1";
const PROYECTOS_URL = `${API_BASE}/proyectos`;
const TAREAS_URL = `${API_BASE}/tareas`;
const PRIORIDADES_URL = `${API_BASE}/prioridades`;
const USUARIOS_URL = `${API_BASE}/usuarios`;
const EQUIPOS_URL = `${API_BASE}/equipos`;
const ESTADOS_PROYECTO_URL = `${API_BASE}/estado-proyecto`;
const ROLES_URL = `${API_BASE}/roles-equipo`;
const PERMISOS_URL = `${API_BASE}/usuarios-equipo`;

function getAuthHeaders() {
  const token = localStorage.getItem("token");
  return {
    "Content-Type": "application/json",
    Authorization: `Bearer ${token}`,
  };
}

const Negocio = (function () {
  // Métodos para Login y Logout
  async function logIn(email, password) {
    const res = await fetch(`${API_BASE}/login`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ email, password }),
    });

    const data = await res.json();

    if (!res.ok || !data.success) {
      throw new Error(data.message || "Error en login");
    }

    // Guardar token y usuario en localStorage (responsabilidad de SeguridadProvider)
    return data; // incluye access_token y user
  }

  async function logOut() {
    const res = await fetch(`${API_BASE}/logout`, {
      method: "POST",
      headers: getAuthHeaders(),
    });

    if (!res.ok) {
      throw new Error("Error al hacer logout");
    }

    return true;
  }

  // Métodos para Proyectos
  async function obtenerProyectos() {
    const res = await fetch(PROYECTOS_URL, {
      headers: getAuthHeaders(),
    });

    if (!res.ok) {
      throw new Error("Error al obtener proyectos");
    }

    return await res.json();
  }

  async function obtenerProyecto(id) {
    const res = await fetch(`${PROYECTOS_URL}/${id}`, {
      headers: getAuthHeaders(),
    });

    if (!res.ok) {
      throw new Error("Error al obtener proyecto");
    }

    return await res.json();
  }

  async function crearProyecto(data) {
    const res = await fetch(PROYECTOS_URL, {
      method: "POST",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });

    const text = await res.text();
    console.log("POST proyectos STATUS:", res.status);
    console.log("POST proyectos RESPONSE:", text);

    if (!res.ok) {
      throw new Error(text || "Error al crear proyecto");
    }

    return text ? JSON.parse(text) : null;
  }

  async function actualizarProyecto(id, data) {
    const res = await fetch(`${PROYECTOS_URL}/${id}`, {
      method: "PUT",
      headers: getAuthHeaders(),
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
      headers: getAuthHeaders(),
    });

    if (!res.ok) {
      throw new Error("Error al eliminar proyecto");
    }

    return true;
  }
  async function obtenerMisProyectos() {
    const res = await fetch(`${API_BASE}/mis-proyectos`, {
      headers: getAuthHeaders(),
    });

    if (!res.ok) {
      throw new Error("Error al obtener mis proyectos");
    }

    return await res.json();
  }
  // Métodos para Equipos
  async function obtenerEquipos() {
    const res = await fetch(EQUIPOS_URL, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener equipos");
    }
    return await res.json();
  }

  async function obtenerEquipo(id) {
    const res = await fetch(`${EQUIPOS_URL}/${id}`, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener equipo");
    }
    return await res.json();
  }

  async function crearEquipo(data) {
    const res = await fetch(EQUIPOS_URL, {
      method: "POST",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      throw new Error(responseData?.detail || "Error al crear equipo");
    }
    return responseData;
  }

  async function actualizarEquipo(id, data) {
    const res = await fetch(`${EQUIPOS_URL}/${id}`, {
      method: "PUT",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      throw new Error(responseData?.detail || "Error al actualizar equipo");
    }
    return responseData;
  }

  async function eliminarEquipo(id) {
    const res = await fetch(`${EQUIPOS_URL}/${id}`, {
      method: "DELETE",
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al eliminar equipo");
    }
    return true;
  }
  async function obtenerMisEquipos() {
    const res = await fetch(`${API_BASE}/mis-equipos`, {
      headers: getAuthHeaders(),
    });

    if (!res.ok) {
      throw new Error("Error al obtener mis equipos");
    }

    return await res.json();
  }
  // Métodos para Roles
  async function obtenerRoles() {
    const res = await fetch(ROLES_URL, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener roles");
    }
    return await res.json();
  }

  async function obtenerRol(id) {
    const res = await fetch(`${ROLES_URL}/${id}`, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener rol");
    }
    return await res.json();
  }

  async function crearRol(data) {
    const res = await fetch(ROLES_URL, {
      method: "POST",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      throw new Error(responseData?.detail || "Error al crear rol");
    }
    return responseData;
  }

  async function actualizarRol(id, data) {
    const res = await fetch(`${ROLES_URL}/${id}`, {
      method: "PUT",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      throw new Error(responseData?.detail || "Error al actualizar rol");
    }
    return responseData;
  }

  async function eliminarRol(id) {
    const res = await fetch(`${ROLES_URL}/${id}`, {
      method: "DELETE",
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al eliminar rol");
    }
    return true;
  }

  // Métodos para Estados de Proyecto
  async function obtenerEstadosProyecto() {
    const res = await fetch(ESTADOS_PROYECTO_URL, {
      headers: getAuthHeaders(),
    });
    return await res.json();
  }

  // Métodos para Tareas

  async function obtenerTareas() {
    const res = await fetch(TAREAS_URL, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener tareas");
    }
    return await res.json();
  }

  async function obtenerTarea(id) {
    const res = await fetch(`${TAREAS_URL}/${id}`, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener tarea");
    }
    return await res.json();
  }

  async function crearTarea(data) {
    const res = await fetch(TAREAS_URL, {
      method: "POST",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      console.log("ERROR BACKEND:", responseData);
      throw new Error("Error al crear tarea");
    }
    return responseData;
  }

  async function actualizarTarea(id, data) {
    const res = await fetch(`${TAREAS_URL}/${id}`, {
      method: "PUT",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      console.log("ERROR BACKEND:", responseData);
      throw new Error("Error al crear tarea");
    }
    return responseData;
  }

  async function eliminarTarea(id) {
    const res = await fetch(`${TAREAS_URL}/${id}`, {
      method: "DELETE",
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al eliminar tarea");
    }
    return true;
  }

  // función para mover una tarea:
  async function moverTarea(id, data) {
    const res = await fetch(`${TAREAS_URL}/${id}/mover`, {
      method: "PATCH",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });

    if (!res.ok) {
      throw new Error("Error moviendo tarea");
    }

    return await res.json();
  }
  async function obtenerMisTareas() {
    const res = await fetch(`${API_BASE}/mis-tareas`, {
      headers: getAuthHeaders(),
    });

    if (!res.ok) {
      throw new Error("Error al obtener mis tareas");
    }

    return await res.json();
  }
  // =============== METODOS PARA COLUMNAS DEL PROYECTO  ===============

  async function obtenerColumnasProyecto(idProyecto) {
    const url = `${PROYECTOS_URL}/${idProyecto}/columnas`;
    const res = await fetch(url, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener las columnas del proyecto");
    }
    return await res.json();
  }

  async function crearColumnaProyecto(idProyecto, data) {
    const url = `${PROYECTOS_URL}/${idProyecto}/columnas`;
    const res = await fetch(url, {
      method: "POST",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      throw new Error(
        responseData?.detail || "Error al crear columna/estado en el proyecto",
      );
    }
    return responseData;
  }

  async function actualizarColumna(idColumna, data) {
    const url = `${API_BASE}/columnas/${idColumna}`;
    const res = await fetch(url, {
      method: "PUT",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      throw new Error(
        responseData?.detail || "Error al actualizar columna/estado",
      );
    }
    return responseData;
  }

  async function eliminarColumna(idColumna) {
    const url = `${API_BASE}/columnas/${idColumna}`;
    const res = await fetch(url, {
      method: "DELETE",
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al eliminar columna/estado");
    }
    return true;
  }

  // Métodos para Prioridades
  async function obtenerPrioridades() {
    const res = await fetch(PRIORIDADES_URL, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener prioridades");
    }
    return await res.json();
  }

  // Métodos para Usuarios
  async function obtenerUsuarios() {
    const res = await fetch(USUARIOS_URL, {
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al obtener usuarios");
    }
    return await res.json();
  }

  // Crear usuario
  async function crearUsuario(data) {
    const res = await fetch(USUARIOS_URL, {
      method: "POST",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      throw new Error(responseData?.detail || "Error al crear usuario");
    }
    return responseData;
  }

  // Editar usuario
  async function actualizarUsuario(id, data) {
    const res = await fetch(`${USUARIOS_URL}/${id}`, {
      method: "PUT",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok) {
      throw new Error(responseData?.detail || "Error al actualizar usuario");
    }
    return responseData;
  }

  // Eliminar usuario
  async function eliminarUsuario(id) {
    const res = await fetch(`${USUARIOS_URL}/${id}`, {
      method: "DELETE",
      headers: getAuthHeaders(),
    });
    if (!res.ok) {
      throw new Error("Error al eliminar usuario");
    }
    return true;
  }

  // ================== Métodos para permisos  ==================

  async function obtenerPermisos() {
    const res = await fetch(PERMISOS_URL, { headers: getAuthHeaders() });
    if (!res.ok) throw new Error("Error al obtener permisos");
    return await res.json();
  }

  async function crearPermiso(data) {
    const res = await fetch(PERMISOS_URL, {
      method: "POST",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok)
      throw new Error(responseData?.detail || "Error al crear permiso");
    return responseData;
  }

  // ✅ PK compuesta: (idUsuario, idEquipo)
  async function editarPermiso(idUsuario, idEquipo, data) {
    const res = await fetch(`${PERMISOS_URL}/${idUsuario}/${idEquipo}`, {
      method: "PUT",
      headers: getAuthHeaders(),
      body: JSON.stringify(data),
    });
    const responseData = await res.json();
    if (!res.ok)
      throw new Error(responseData?.detail || "Error al editar permiso");
    return responseData;
  }

  async function eliminarPermiso(idUsuario, idEquipo) {
    const res = await fetch(`${PERMISOS_URL}/${idUsuario}/${idEquipo}`, {
      method: "DELETE",
      headers: getAuthHeaders(),
    });
    if (!res.ok) throw new Error("Error al eliminar permiso");
    return true;
  }

  return {
    // Login y Logout (para SeguridadProvider)
    logIn,
    logOut,
    // Proyectos
    obtenerProyectos,
    obtenerProyecto,
    crearProyecto,
    actualizarProyecto,
    eliminarProyecto,
    obtenerMisProyectos,
    // Equipos y Estados de Proyecto
    obtenerEquipos,
    obtenerEquipo,
    crearEquipo,
    actualizarEquipo,
    eliminarEquipo,
    obtenerEstadosProyecto,
    obtenerMisEquipos,
    // Roles
    obtenerRoles,
    obtenerRol,
    crearRol,
    actualizarRol,
    eliminarRol,
    // Tareas
    obtenerTareas,
    obtenerTarea,
    crearTarea,
    actualizarTarea,
    eliminarTarea,
    moverTarea,
    obtenerMisTareas,
    // Prioridades y Usuarios
    obtenerPrioridades,
    obtenerUsuarios,
    crearUsuario,
    actualizarUsuario,
    eliminarUsuario,
    // Columnas por Proyecto (Estados de Tarea específicos por proyecto)
    obtenerColumnasProyecto,
    crearColumnaProyecto,
    actualizarColumna,
    eliminarColumna,
    // permisos
    obtenerPermisos,
    crearPermiso,
    editarPermiso,
    eliminarPermiso,
  };
})();

export default Negocio;
