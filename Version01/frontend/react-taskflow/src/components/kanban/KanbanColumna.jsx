import { useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";
import KanbanCard from "./KanbanCard";

function KanbanColumna({
  columna,
  tareas,
  onDragStart,
  onDrop,
  onDragOver,
  onNuevaTarea,
  onAbrirDetalle,
  mostrarAgregarColumna,
  onAgregarColumna,
  onEditarColumna,
  onEliminarColumna,
}) {
  const { datos } = useContext(SeguridadContext);

  const esAdmin = datos?.rolActivo === "ADMIN";
  console.log("ROL ACTIVO:", datos?.rolActivo);
  return (
    <div
      className="kanban-column"
      onDragOver={(e) => e.preventDefault()}
      onDrop={(e) => onDrop(e, columna.id)}
      /* min/max widths via CSS main.css (.kanban-column) */
    >
      <div className="kanban-column-header d-flex align-items-center justify-content-between mb-2">
        <h5
          className={`kanban-column-title ${esAdmin ? "editable" : ""}`}
          onDoubleClick={() => esAdmin && onEditarColumna(columna)}
        >
          {columna.nombre}
        </h5>

        {esAdmin && (
          <button
            className="btn btn-sm p-0 border-0"
            style={{ background: "none" }}
            onClick={() => onEliminarColumna(columna.id)}
            title="Eliminar columna"
          >
            <i className="bi bi-trash"></i>
          </button>
        )}
      </div>

      <button
        className="btn btn-sm btn-outline-primary w-100 mb-2"
        onClick={() => onNuevaTarea(columna.id)}
      >
        <i className="bi bi-plus-lg me-2"></i>
        Nueva tarea
      </button>

      <div className="kanban-task-list">
        {tareas.map((tarea) => (
          <KanbanCard
            key={tarea.id}
            tarea={tarea}
            onDragStart={onDragStart}
            onAbrirDetalle={onAbrirDetalle}
          />
        ))}
      </div>

      {esAdmin && mostrarAgregarColumna && (
        <button
          className="add-column-card btn btn-outline-success w-100 mt-3"
          onClick={onAgregarColumna}
        >
          <i className="bi bi-plus-lg me-2"></i>
          Agregar columna
        </button>
      )}
    </div>
  );
}

export default KanbanColumna;
