import React, { useEffect, useState } from "react";
import {
  getProyectos,
  createProyecto,
  updateProyecto,
} from "../data/proyectosApi";
import ProyectoModal from "../components/ProyectoModal";

// Card del Proyecto: muestra ícono de editar y fechas relevantes
function ProjectCard({
  nombre,
  descripcion,
  fecha_inicio,
  fecha_fin_prevista,
  color,
  onEdit,
}) {
  return (
    <div
      className="card h-100 shadow-sm position-relative"
      style={{ minWidth: 220 }}
    >
      {/* Botón editar */}
      <button
        type="button"
        className="btn btn-sm btn-light position-absolute"
        style={{
          top: 8,
          right: 10,
          zIndex: 2,
          boxShadow: "0 2px 8px rgba(0,0,0,.04)",
          borderRadius: "50%",
          padding: "4px 6px",
          border: "none",
        }}
        title="Editar proyecto"
        aria-label="Editar proyecto"
        onClick={onEdit}
      >
        <i className="bi bi-pencil"></i>
      </button>
      <div
        className="card-img-top d-flex align-items-center justify-content-center"
        style={{
          height: 120,
          backgroundColor: color || "#6c63ff",
          borderTopLeftRadius: ".375rem",
          borderTopRightRadius: ".375rem",
        }}
      >
        <span className="fw-bold" style={{ color: "#fff", fontSize: "2rem" }}>
          {nombre ? nombre.charAt(0) : "?"}
        </span>
      </div>
      <div className="card-body pb-2">
        <h5 className="card-title mb-1">{nombre}</h5>
        <p className="card-text text-muted" style={{ fontSize: "0.95rem" }}>
          {descripcion}
        </p>
        {/* Mostrando fechas si existen */}
        <div className="small text-muted mt-2">
          {fecha_inicio && (
            <div>
              <i className="bi bi-calendar-week me-1"></i>
              Inicio: {fecha_inicio}
            </div>
          )}
          {fecha_fin_prevista && (
            <div>
              <i className="bi bi-flag me-1"></i>
              Fin Prevista: {fecha_fin_prevista}
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

// Card para crear nuevo tablero
function CrearNuevoTableroCard({ onClick }) {
  return (
    <div
      className="card h-100 border-dashed shadow-sm"
      style={{
        minWidth: 220,
        border: "2px dashed #b2bec3",
        color: "#636e72",
        cursor: "pointer",
        transition: "border-color .2s, color .2s",
      }}
      tabIndex={0}
      onClick={onClick}
      onKeyPress={(e) => {
        if (e.key === "Enter" || e.key === " ") onClick && onClick();
      }}
      role="button"
      aria-label="Crear nuevo tablero"
    >
      <div
        className="card-body d-flex flex-column justify-content-center align-items-center"
        style={{ height: 170 }}
      >
        <span className="fs-1 mb-2" role="img" aria-label="plus">
          <i className="bi bi-plus-circle"></i>
        </span>
        <span className="fw-bold">Crear nuevo tablero</span>
      </div>
    </div>
  );
}

function ProjectDashboard() {
  const [proyectos, setProyectos] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Estado para mostrar el modal de crear/editar proyecto
  const [showModal, setShowModal] = useState(false);
  const [modalInitialData, setModalInitialData] = useState(null);

  useEffect(() => {
    let ignore = false;

    async function fetchProyectos() {
      setLoading(true);
      setError(null);
      try {
        const data = await getProyectos();
        if (!ignore) {
          setProyectos(data);
        }
      } catch (_e) {
        if (!ignore) {
          setError("Error cargando proyectos");
        }
      } finally {
        if (!ignore) {
          setLoading(false);
        }
      }
    }

    fetchProyectos();

    return () => {
      ignore = true;
    };
  }, []);

  const destacados = proyectos.slice(0, 2);

  // Sólo los campos permitidos al crear
  function getProyectoEditableFields(obj) {
    const { nombre, descripcion, fecha_inicio, fecha_fin_prevista } = obj;
    return { nombre, descripcion, fecha_inicio, fecha_fin_prevista };
  }

  // Handler para crear proyecto (solo campos permitidos)
  async function handleCreateProyecto(newProyecto) {
    setLoading(true);
    setError(null);
    try {
      // Tomamos sólo los campos permitidos
      const toSave = getProyectoEditableFields(newProyecto);
      const creado = await createProyecto(toSave);
      setProyectos((prev) => [...prev, creado]);
      setShowModal(false);
      setModalInitialData(null);
    } catch (_e) {
      setError("No se pudo crear el proyecto");
    } finally {
      setLoading(false);
    }
  }

  // Handler para editar proyecto (solo campos permitidos)
  async function handleEditProyecto(editedProyecto) {
    setLoading(true);
    setError(null);
    try {
      // Solo permitimos modificar los campos seleccionados
      const toUpdate = getProyectoEditableFields(editedProyecto);
      const actualizado = await updateProyecto(modalInitialData.id, toUpdate);
      setProyectos((prev) =>
        prev.map((p) =>
          String(p.id) === String(modalInitialData.id) ? actualizado : p
        )
      );
      setShowModal(false);
      setModalInitialData(null);
    } catch (_e) {
      setError("No se pudo editar el proyecto");
    } finally {
      setLoading(false);
    }
  }

  // Decide si el modal es de creación o de edición según initialData
  function handleModalSubmit(data) {
    if (modalInitialData) {
      handleEditProyecto(data);
    } else {
      handleCreateProyecto(data);
    }
  }

  // Para abrir el modal en modo editar
  function openEditModal(project) {
    // Nos aseguramos de pasar solo los campos editables al modal
    setModalInitialData(
      getProyectoEditableFields({ ...project, id: project.id })
    );
    setShowModal(true);
  }

  // Para abrir el modal en modo crear
  function openCreateModal() {
    setModalInitialData(null);
    setShowModal(true);
  }

  return (
    <main
      className="container-fluid px-4 py-4"
      style={{ background: "#f9fafb", minHeight: "100vh" }}
    >
      {/* Tableros Destacados */}
      <section className="mb-5">
        <div className="mb-3 d-flex align-items-center justify-content-between">
          <h4 className="fw-bold mb-0">Tableros Destacados</h4>
        </div>
        <div className="d-flex flex-row gap-4 overflow-auto pb-2">
          {loading && <span>Cargando...</span>}
          {error && <span className="text-danger">{error}</span>}
          {!loading &&
            !error &&
            destacados.map((proyecto) => (
              <div key={proyecto.id} style={{ minWidth: 260, maxWidth: 280 }}>
                <ProjectCard
                  {...proyecto}
                  onEdit={() => openEditModal(proyecto)}
                />
              </div>
            ))}
        </div>
      </section>

      {/* Tus Espacios de Trabajo */}
      <section>
        <div className="mb-3 d-flex align-items-center justify-content-between">
          <h4 className="fw-bold mb-0">Tus Espacios de Trabajo</h4>
        </div>
        <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
          {/* Card para crear nuevo tablero */}
          <div className="col">
            <CrearNuevoTableroCard onClick={openCreateModal} />
          </div>
          {/* Proyecto cards */}
          {loading && (
            <div className="col">
              <div className="text-muted py-4">Cargando proyectos...</div>
            </div>
          )}
          {error && (
            <div className="col">
              <div className="text-danger py-4">{error}</div>
            </div>
          )}
          {!loading &&
            !error &&
            proyectos.map((proyecto) => (
              <div key={proyecto.id} className="col">
                <ProjectCard
                  {...proyecto}
                  onEdit={() => openEditModal(proyecto)}
                />
              </div>
            ))}
        </div>
      </section>

      {/* Modal para crear o editar proyecto */}
      <ProyectoModal
        show={showModal}
        onClose={() => {
          setShowModal(false);
          setModalInitialData(null);
        }}
        onSubmit={handleModalSubmit}
        initialData={modalInitialData}
      />
    </main>
  );
}

export default ProjectDashboard;
