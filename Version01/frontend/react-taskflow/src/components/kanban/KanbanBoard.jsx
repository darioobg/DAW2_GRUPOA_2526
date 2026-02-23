import { useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";
import KanbanColumna from "./KanbanColumna";

function KanbanBoard({
  columnas,
  getTareasPorColumna,
  onDragStart,
  onDrop,
  onDragOver,
  onNuevaTarea,
  onAbrirDetalle,
  onNuevaColumna,
  onEditarColumna,
  onEliminarColumna,
}) {
  const { datos } = useContext(SeguridadContext);

  const esAdmin = datos?.rolActivo === "ADMIN";

  return (
    <div className="kanban-wrapper">
      {columnas.map((columna) => (
        <KanbanColumna
          key={columna.id}
          columna={columna}
          tareas={getTareasPorColumna(columna.id)}
          onDragStart={onDragStart}
          onDrop={onDrop}
          onDragOver={onDragOver}
          onNuevaTarea={onNuevaTarea}
          onAbrirDetalle={onAbrirDetalle}
          onEditarColumna={onEditarColumna}
          onEliminarColumna={onEliminarColumna}
        />
      ))}

      {esAdmin && (
        <div className="kanban-column kanban-column--add">
          <button
            className="btn btn-outline-success w-100"
            onClick={onNuevaColumna}
          >
            + Agregar columna
          </button>
        </div>
      )}
    </div>
  );
}

export default KanbanBoard;
