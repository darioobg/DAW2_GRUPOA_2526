import React from "react";

export default function MisTareasTable({ tareas }) {
  return (
    <div className="tabla-container">
      <div className="tabla">
        {/* Header */}
        <div className="tabla-row tabla-header">
          <div className="tabla-cell">Título</div>
          <div className="tabla-cell">Proyecto</div>
          <div className="tabla-cell">Estado</div>
          <div className="tabla-cell">Prioridad</div>
          <div className="tabla-cell">Fecha Límite</div>
        </div>

        {/* Body */}
        {tareas.map((t) => (
          <div key={t.id} className="tabla-row">
            <div className="tabla-cell">{t.titulo}</div>
            <div className="tabla-cell">{t.proyectoNombre}</div>
            <div className="tabla-cell">{t.estadoNombre}</div>
            <div className="tabla-cell">{t.prioridadNombre}</div>
            <div className="tabla-cell">{t.fechaLimite || "Sin fecha"}</div>
          </div>
        ))}
      </div>
    </div>
  );
}
