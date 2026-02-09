const API_URL = "http://127.0.0.1:8000/api/v1";

export async function getProyectos() {
  const response = await fetch(`${API_URL}/proyectos`);
  if (!response.ok) {
    throw new Error("Error fetching proyectos");
  }
  return response.json();
}
