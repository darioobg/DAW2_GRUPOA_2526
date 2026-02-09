import React, { useState } from "react";

// Helper to get today's date in YYYY-MM-DD
function getTodayDateStr() {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, "0");
  const dd = String(today.getDate()).padStart(2, "0");
  return `${yyyy}-${mm}-${dd}`;
}

// Helper to get date in YYYY-MM-DD format (handles ISO or Date object)
function formatDateForInput(date) {
  if (!date) return "";
  if (typeof date === "string" && date.match(/^\d{4}-\d{2}-\d{2}$/)) {
    return date;
  }
  // Parse to Date, then format
  const d = new Date(date);
  if (isNaN(d.getTime())) return "";
  const yyyy = d.getFullYear();
  const mm = String(d.getMonth() + 1).padStart(2, "0");
  const dd = String(d.getDate()).padStart(2, "0");
  return `${yyyy}-${mm}-${dd}`;
}

function ProyectoForm({ initialData = null, onSubmit }) {
  // Default values, now loaded on first render, even for date fields
  const [nombre, setNombre] = useState(initialData?.nombre || "");
  const [descripcion, setDescripcion] = useState(
    initialData?.descripcion || ""
  );
  const [fecha_inicio, setFechaInicio] = useState(
    initialData && initialData.fecha_inicio
      ? formatDateForInput(initialData.fecha_inicio)
      : ""
  );
  const [fecha_fin_prevista, setFechaFinPrevista] = useState(
    initialData && initialData.fecha_fin_prevista
      ? formatDateForInput(initialData.fecha_fin_prevista)
      : ""
  );

  // If initialData changes, update form fields (shows correct data when editing)
  React.useEffect(() => {
    setNombre(initialData?.nombre || "");
    setDescripcion(initialData?.descripcion || "");
    setFechaInicio(
      initialData && initialData.fecha_inicio
        ? formatDateForInput(initialData.fecha_inicio)
        : ""
    );
    setFechaFinPrevista(
      initialData && initialData.fecha_fin_prevista
        ? formatDateForInput(initialData.fecha_fin_prevista)
        : ""
    );
  }, [initialData]);

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!nombre.trim()) return;
    onSubmit &&
      onSubmit({
        nombre: nombre.trim(),
        descripcion: descripcion.trim(),
        id_equipo: 2,
        fecha_creacion: getTodayDateStr(),
        fecha_inicio,
        fecha_fin_prevista,
        id_estado_proyecto: 2,
      });
  };

  return (
    <form onSubmit={handleSubmit}>
      <div className="mb-3">
        <label htmlFor="nombreProyecto" className="form-label">
          Nombre del Proyecto
        </label>
        <input
          type="text"
          className="form-control"
          id="nombreProyecto"
          value={nombre}
          onChange={(e) => setNombre(e.target.value)}
          maxLength={40}
          required
        />
      </div>
      <div className="mb-3">
        <label htmlFor="descripcionProyecto" className="form-label">
          Descripción
        </label>
        <textarea
          className="form-control"
          id="descripcionProyecto"
          rows={3}
          value={descripcion}
          onChange={(e) => setDescripcion(e.target.value)}
          maxLength={200}
        />
      </div>
      {/* Hidden input for id_equipo (always 2) */}
      <input type="hidden" id="idEquipo" value={2} readOnly />
      {/* Hidden input for id_estado_proyecto (always 2) */}
      <input type="hidden" id="idEstadoProyecto" value={2} readOnly />
      <div className="mb-3">
        <label htmlFor="fechaInicio" className="form-label">
          Fecha de Inicio
        </label>
        <input
          type="date"
          className="form-control"
          id="fechaInicio"
          value={fecha_inicio}
          onChange={(e) => setFechaInicio(e.target.value)}
          required
        />
      </div>
      <div className="mb-3">
        <label htmlFor="fechaFinPrevista" className="form-label">
          Fecha Fin Prevista
        </label>
        <input
          type="date"
          className="form-control"
          id="fechaFinPrevista"
          value={fecha_fin_prevista}
          onChange={(e) => setFechaFinPrevista(e.target.value)}
          required
        />
      </div>
      <div className="d-flex justify-content-end">
        <button type="submit" className="btn btn-primary">
          {initialData ? "Guardar Cambios" : "Crear Proyecto"}
        </button>
      </div>
    </form>
  );
}

export default ProyectoForm;
