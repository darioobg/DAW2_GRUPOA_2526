import { useLocation, useParams } from "react-router-dom";
import { useState, useEffect } from "react";
import TareaModal from "../components/TareaModal";
import KanbanBoard from "../components/kanban/KanbanBoard";
import Negocio from "../core/Negocio";

export default function TableroDetallePage() {
  const { idTablero } = useParams();
  const location = useLocation();

  const idFinal = idTablero ?? location.state?.idTablero ?? null;

  const [tareas, setTareas] = useState([]);
  const [tareaArrastradaId, setTareaArrastradaId] = useState(null);
  const [cargando, setCargando] = useState(true);
  const [error, setError] = useState(null);
  const [showModal, setShowModal] = useState(false);
  const [estadoSeleccionado, setEstadoSeleccionado] = useState(null);

  const columnas = [
    { key: 1, nombre: "Por hacer" },
    { key: 2, nombre: "En progreso" },
    { key: 3, nombre: "En revisión" },
    { key: 4, nombre: "Hecho" },
  ];

  useEffect(() => {
    async function fetchTareas() {
      try {
        setCargando(true);
        setError(null);

        // Utiliza la api de negocio para obtener tareas del proyecto
        if (idFinal) {
          const todasTareas = await Negocio.obtenerTareas();
          // Filtra las tareas por el id del proyecto actual
          setTareas(
            (todasTareas || []).filter(
              (t) => String(t.idProyecto) === String(idFinal),
            ),
          );
        } else {
          setTareas([]);
        }
      } catch (err) {
        console.error(err);
        setError("Error al cargar tareas");
      } finally {
        setCargando(false);
      }
    }

    if (idFinal) {
      fetchTareas();
    }
  }, [idFinal]);

  function getTareasOrdenadasPorColumna(keyColumna) {
    return tareas
      .filter((t) => Number(t.idEstado) === Number(keyColumna))
      .slice()
      .sort((a, b) => Number(a.ordenKanban) - Number(b.ordenKanban));
  }

  function abrirModalNuevaTarea(idEstado) {
    setEstadoSeleccionado(idEstado);
    setShowModal(true);
  }

  async function crearTarea(data) {
    try {
      // Usa el api de negocio tareas
      await Negocio.crearTarea({
        ...data,
        idProyecto: idFinal,
        ordenKanban: tareas.length + 1,
      });

      // Refresca las tareas usando la misma lógica de fetchTareas:
      const todasTareas = await Negocio.obtenerTareas();
      setTareas(
        (todasTareas || []).filter(
          (t) => String(t.idProyecto) === String(idFinal),
        ),
      );

      setShowModal(false);
    } catch (error) {
      console.error("Error creando tarea:", error);
    }
  }

  function handleDragStart(e, tareaId) {
    setTareaArrastradaId(tareaId);
  }

  function handleDragOver(e) {
    e.preventDefault();
  }

  async function handleDrop(e, keyColumnaDestino) {
    e.preventDefault();

    if (!tareaArrastradaId) return;

    try {
      // Usa el api de negocio tareas para mover tarea
      await Negocio.moverTarea(tareaArrastradaId, {
        idEstado: keyColumnaDestino,
        ordenKanban: 1,
      });

      const todasTareas = await Negocio.obtenerTareas();
      setTareas(
        (todasTareas || []).filter(
          (t) => String(t.idProyecto) === String(idFinal),
        ),
      );
    } catch (error) {
      console.error("Error moviendo tarea:", error);
    }

    setTareaArrastradaId(null);
  }

  if (!idFinal) {
    return (
      <div className="alert alert-danger text-center mt-4">
        Proyecto no válido
      </div>
    );
  }

  return (
    <div className="container py-4">
      <h1 className="fw-bold mb-4">
        Tablero: <span className="text-primary">{idFinal}</span>
      </h1>

      {cargando ? (
        <div className="alert alert-info text-center">Cargando tareas...</div>
      ) : error ? (
        <div className="alert alert-danger text-center">{error}</div>
      ) : (
        <>
          <KanbanBoard
            columnas={columnas}
            tareas={tareas}
            getTareasPorColumna={getTareasOrdenadasPorColumna}
            onDragStart={handleDragStart}
            onDragOver={handleDragOver}
            onDrop={handleDrop}
            onNuevaTarea={abrirModalNuevaTarea}
          />

          <TareaModal
            show={showModal}
            onClose={() => setShowModal(false)}
            idProyecto={idFinal}
            idEstado={estadoSeleccionado}
            onSubmit={crearTarea}
          />
        </>
      )}
    </div>
  );
}
