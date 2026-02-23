import { useEffect, useState, useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";
import Negocio from "../../core/Negocio";
import MisTareasTable from "../../components/tarea/MisTareasTable";

export default function MisTareasPage() {
  const { datos } = useContext(SeguridadContext);

  const [tareas, setTareas] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    cargarMisTareas();
  }, []);

  async function cargarMisTareas() {
    try {
      setLoading(true);
      setError(null);

      const data = await Negocio.obtenerMisTareas();
      setTareas(data);
    } catch (err) {
      console.error(err);
      setError("Error cargando tareas");
    } finally {
      setLoading(false);
    }
  }

  if (loading) return <div>Cargando tareas...</div>;
  if (error) return <div className="text-danger">{error}</div>;

  return (
    <div className="mis-tareas-container">
      <h1>Mis Tareas</h1>

      {tareas.length === 0 ? (
        <div>No tienes tareas asignadas.</div>
      ) : (
        <MisTareasTable tareas={tareas} />
      )}
    </div>
  );
}
