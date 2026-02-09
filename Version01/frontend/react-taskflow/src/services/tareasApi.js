const API_URL = "http://127.0.0.1:8000/api/v1";

export async function obtenerTareasPorTablero(idTablero) {
  const response = await fetch(`${API_URL}/tareas?idProyecto=${idTablero}`);
  return response.json();
}
