import React from "react";

export default function MisTareasTable({ tareas }) {
  const getEstadoStyle = (estado) => {
    switch (estado) {
      case "Pendiente":
        return "bg-secondary-subtle text-secondary";
      case "En Progreso":
        return "bg-primary-subtle text-primary";
      case "Finalizado":
        return "bg-success-subtle text-success";
      default:
        return "bg-light text-dark";
    }
  };

  const getPrioridadStyle = (prioridad) => {
    switch (prioridad) {
      case "alta":
        return "bg-danger-subtle text-danger";
      case "media":
        return "bg-warning-subtle text-warning";
      case "baja":
        return "bg-secondary-subtle text-secondary";
      default:
        return "bg-light text-dark";
    }
  };

  return (
    <div className="container mt-4">
      <div className="p-4 rounded-4" style={{ backgroundColor: "#f3f4f6" }}>
        <div className="d-flex justify-content-end mb-4">
          <span className="badge bg-light text-dark">
            {tareas.length} tareas
          </span>
        </div>

        {/* Header */}
        <div className="row fw-semibold text-muted mb-3 px-3">
          <div className="col-md-3">Título</div>
          <div className="col-md-3">Proyecto</div>
          <div className="col-md-2">Estado</div>
          <div className="col-md-2">Prioridad</div>
          <div className="col-md-2">Fecha Límite</div>
        </div>

        {/* Filas */}
        {tareas.map((t) => (
          <div
            key={t.id}
            className="row align-items-center py-3 px-3 mb-2 rounded-4"
            style={{
              backgroundColor: "#ffffff",
              transition: "all 0.2s ease",
            }}
          >
            <div className="col-md-3 fw-semibold">{t.titulo}</div>

            <div className="col-md-3 text-muted">{t.proyectoNombre}</div>

            <div className="col-md-2">
              <span
                className={`badge rounded-pill px-3 py-2 ${getEstadoStyle(t.estadoNombre)}`}
              >
                {t.estadoNombre}
              </span>
            </div>

            <div className="col-md-2">
              <span
                className={`badge rounded-pill px-3 py-2 ${getPrioridadStyle(t.prioridadNombre)}`}
              >
                {t.prioridadNombre}
              </span>
            </div>

            <div className="col-md-2">
              {t.fechaLimite ? (
                <span>{new Date(t.fechaLimite).toLocaleDateString()}</span>
              ) : (
                <span className="text-muted">Sin fecha</span>
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}