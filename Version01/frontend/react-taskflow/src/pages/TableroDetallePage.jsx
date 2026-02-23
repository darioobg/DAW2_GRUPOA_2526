import { useLocation, useParams, useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import TareaModal from "../components/tarea/TareaModal";
import KanbanBoard from "../components/kanban/KanbanBoard";
import Negocio from "../core/Negocio";
import ModalDetalleTarea from "../components/tarea/ModalDetalleTarea";
import TableroMenuLateral from "../components/ui/TableroMenuLateral";
import ProyectoModal from "../components/proyecto/ProyectoModal";

export default function TableroDetallePage() {
  const { idTablero } = useParams();
  const location = useLocation();
  const navigate = useNavigate();

  const idFinal = idTablero ?? location.state?.idTablero ?? null;

  // ===== ESTADOS =====
  const [proyecto, setProyecto] = useState(null);
  const [tareas, setTareas] = useState([]);
  const [tareaArrastradaId, setTareaArrastradaId] = useState(null);
  const [cargando, setCargando] = useState(true);
  const [error, setError] = useState(null);

  const [showModal, setShowModal] = useState(false);
  const [estadoSeleccionado, setEstadoSeleccionado] = useState(null);

  const [tareaSeleccionada, setTareaSeleccionada] = useState(null);
  const [showDetalle, setShowDetalle] = useState(false);

  const [menuLateralAbierto, setMenuLateralAbierto] = useState(false);
  const [showProyectoModal, setShowProyectoModal] = useState(false);
  const [modalInitialData, setModalInitialData] = useState(null);

  const [columnas, setColumnas] = useState([]);

  // Un solo useEffect para cargar estados y datos iniciales al montar o cambiar idFinal
  useEffect(() => {
    let isMounted = true;
    async function fetchAllData() {
      setCargando(true);
      setError(null);
      // Cargar columnas/estados de tarea
      try {
        // Usar el API de columnas por proyecto
        const columnasProyecto = await Negocio.obtenerColumnasProyecto(idFinal);
        if (isMounted) {
          setColumnas(
            (columnasProyecto || []).map((col) => ({
              id: col.id,
              nombre: col.nombre,
            })),
          );
        }
      } catch (err) {
        console.error("Error al obtener columnas del proyecto:", err);
        if (isMounted) {
          setColumnas([
            { key: 1, nombre: "Por hacer" },
            { key: 2, nombre: "En progreso" },
            { key: 3, nombre: "En revisión" },
            { key: 4, nombre: "Hecho" },
          ]);
        }
      }

      // Si no hay idFinal, solo termina la carga
      if (!idFinal) {
        setCargando(false);
        return;
      }

      // Cargar proyecto y tareas
      try {
        const [todasTareas, proyectoData] = await Promise.all([
          Negocio.obtenerTareas(),
          Negocio.obtenerProyecto(idFinal),
        ]);

        if (isMounted) {
          setProyecto(proyectoData);
          setTareas(
            (todasTareas || []).filter(
              (t) => String(t.idProyecto) === String(idFinal),
            ),
          );
        }
      } catch (err) {
        console.error(err);
        if (isMounted) setError("Error al cargar proyecto");
      } finally {
        if (isMounted) setCargando(false);
      }
    }

    fetchAllData();
    return () => {
      isMounted = false;
    };
  }, [idFinal]);

  // ===== KANBAN =====
  function getTareasOrdenadasPorColumna(keyColumna) {
    return tareas
      .filter((t) => Number(t.idEstado) === Number(keyColumna))
      .slice()
      .sort((a, b) => Number(a.ordenKanban) - Number(b.ordenKanban));
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

  // ===== CREAR TAREA =====
  function abrirModalNuevaTarea(idEstado) {
    setEstadoSeleccionado(idEstado);
    setShowModal(true);
  }

  async function crearTarea(data) {
    try {
      await Negocio.crearTarea({
        ...data,
        id_proyectos: idFinal,
        orden_kanban: tareas.length + 1,
      });

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

  // ===== DETALLE TAREA =====
  const onAbrirDetalle = (tarea) => {
    setTareaSeleccionada(tarea);
    setShowDetalle(true);
  };

  const onCerrarDetalle = () => {
    setShowDetalle(false);
    setTareaSeleccionada(null);
  };

  async function actualizarTarea(data) {
    await Negocio.actualizarTarea(data.id, data);
    const proyectoActualizado = await Negocio.obtenerProyecto(idFinal);
    setTareas(proyectoActualizado.tareas || []);
  }

  async function eliminarTarea(id) {
    await Negocio.eliminarTarea(id);
    const proyectoActualizado = await Negocio.obtenerProyecto(idFinal);
    setTareas(proyectoActualizado.tareas || []);
  }

  // ===== ACCIONES PROYECTO =====
  async function handleArchiveProyecto(id) {
    if (!id) return;

    const confirmado = window.confirm(
      "¿Está seguro que desea archivar este proyecto? Esta acción no se puede deshacer.",
    );
    if (!confirmado) return;

    try {
      await Negocio.eliminarProyecto(id);
      navigate("/");
    } catch (error) {
      console.error("Error archivando proyecto:", error);
    }
  }

  if (!idFinal) {
    return (
      <div className="alert alert-danger text-center mt-4">
        Proyecto no válido
      </div>
    );
  }
  function handleEditProyecto() {
    if (!proyecto) return;

    setModalInitialData(proyecto);
    setShowProyectoModal(true);
  }
  // Refactor para que funcione correctamente en el contexto de TableroDetallePage

  async function handleNuevaColumna() {
    const nombre = prompt("Nombre de la nueva columna:");
    if (!nombre) return;

    try {
      const nuevaColumna = await Negocio.crearColumnaProyecto(idFinal, {
        nombre,
        orden: columnas.length + 1,
      });

      // Agregarla directamente al estado
      setColumnas((prev) => [...prev, nuevaColumna]);
    } catch (error) {
      console.error("Error creando columna:", error);
      alert("No se pudo crear la columna.");
    }
  }
  async function handleEditarColumna(columna) {
    const nuevoNombre = prompt("Nuevo nombre:", columna.nombre);
    console.log("EDITAR columna:", columna);
    if (!nuevoNombre) return;

    try {
      const columnaActualizada = await Negocio.actualizarColumna(columna.id, {
        nombre: nuevoNombre,
      });

      setColumnas((prev) =>
        prev.map((col) => (col.id === columna.id ? columnaActualizada : col)),
      );
    } catch (error) {
      console.error(error);
    }
  }

  async function handleEliminarColumna(id) {
    console.log("ELIMINAR id:", id);
    if (!window.confirm("¿Eliminar columna?")) return;

    try {
      await Negocio.eliminarColumna(id);

      setColumnas((prev) => prev.filter((col) => col.id !== id));
    } catch (error) {
      console.error(error);
    }
  }
  const totalTareas = tareas.length;

  const pendientes = tareas.filter((t) => t.idColumna === 1).length;

  const finalizadas = tareas.filter((t) => t.idColumna === 3).length;
  return (
    <div className="tablero-detalle tablero-detalle-asana py-4 px-3">
      {/* ===== HEADER MODERNO ===== */}
      <div className="board-header-modern mb-4 d-flex flex-wrap align-items-center justify-content-between shadow-sm">
        <div className="board-header-left d-flex align-items-center">
          <div className="board-icon me-3 d-flex align-items-center justify-content-center">
            <span
              style={{
                color: "#fff",
                fontWeight: "bold",
                fontSize: "1.5rem",
                letterSpacing: "1px",
              }}
            >
              TF
            </span>
          </div>
          <div>
            <h2 className="board-title mb-0 fw-bold">
              {proyecto && proyecto.nombre ? proyecto.nombre : "Cargando..."}
            </h2>
            <span className="board-subtitle d-block">Tablero de proyecto</span>
          </div>
        </div>

        <div className="board-metrics d-flex gap-3 align-items-center">
          <div className="metric-box text-center px-3 py-2 rounded-3 bg-light">
            <span className="metric-value d-block fw-semibold fs-5 text-primary">
              {totalTareas}
            </span>
            <span className="metric-label small">Tareas</span>
          </div>
          <div
            className="metric-box warning text-center px-3 py-2 rounded-3"
            style={{ background: "#fffae7" }}
          >
            <span className="metric-value d-block fw-semibold fs-5 text-warning">
              {pendientes}
            </span>
            <span className="metric-label small">Pendientes</span>
          </div>
          <div
            className="metric-box success text-center px-3 py-2 rounded-3"
            style={{ background: "#eafbf5" }}
          >
            <span className="metric-value d-block fw-semibold fs-5 text-success">
              {finalizadas}
            </span>
            <span className="metric-label small">Finalizadas</span>
          </div>
        </div>

        <button
          className="btn btn-gradient-primary board-panel-btn ms-3 d-flex align-items-center px-4 py-2"
          type="button"
          onClick={() => setMenuLateralAbierto(true)}
        >
          <i className="bi bi-layout-sidebar me-2 fs-5"></i>
          Panel
        </button>
      </div>

      {/* ===== MENÚ LATERAL ===== */}
      <TableroMenuLateral
        isOpen={menuLateralAbierto}
        onClose={() => setMenuLateralAbierto(false)}
        proyecto={proyecto}
        onEdit={handleEditProyecto}
        onArchive={() => handleArchiveProyecto(proyecto?.id)}
      />

      {/* ===== CONTENIDO ===== */}
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
            onAbrirDetalle={onAbrirDetalle}
            onNuevaColumna={handleNuevaColumna}
            onEditarColumna={handleEditarColumna}
            onEliminarColumna={handleEliminarColumna}
          />

          <TareaModal
            show={showModal}
            onClose={() => setShowModal(false)}
            idProyecto={idFinal}
            idEstado={estadoSeleccionado}
            onSubmit={crearTarea}
          />
          <ProyectoModal
            show={showProyectoModal}
            onClose={() => setShowProyectoModal(false)}
            onSubmit={async (payload) => {
              await Negocio.actualizarProyecto(proyecto.id, payload);

              const proyectoActualizado =
                await Negocio.obtenerProyecto(idFinal);
              setProyecto(proyectoActualizado);

              setShowProyectoModal(false);
            }}
            initialData={modalInitialData}
          />
          {showDetalle && tareaSeleccionada && (
            <ModalDetalleTarea
              tarea={tareaSeleccionada}
              onClose={onCerrarDetalle}
              onActualizar={actualizarTarea}
              onEliminar={eliminarTarea}
            />
          )}
        </>
      )}
    </div>
  );
}
