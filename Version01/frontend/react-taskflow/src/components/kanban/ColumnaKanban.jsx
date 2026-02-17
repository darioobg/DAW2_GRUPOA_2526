import React from "react";
import TarjetaTarea from "./TarjetaTarea"; // Asegúrate de importar el componente TarjetaTarea

/**
 * ColumnaKanban
 * Componente para mostrar una columna estilo Kanban.
 * Props:
 *  - estado: string (nombre del estado/columna)
 *  - tareas: array de objetos tarea { id, titulo, ... }
 */
const ColumnaKanban = ({ estado, tareas, onDragStart }) => {
  return (
    <div className="card shadow-sm border-0 h-100 bg-light">
      {/* Encabezado de la columna */}
      <div className="card-header bg-white text-center border-0">
        <h5 className="card-title mb-0">{estado}</h5>

        <button
          className="btn btn-sm btn-outline-primary w-100 mb-2"
          onClick={() => onNuevaTarea(estadoKey)}
        >
          + Nueva tarea
        </button>
      </div>

      {/* Lista de tareas */}
      <div className="card-body">
        <div className="list-unstyled">
          {tareas && tareas.length > 0 ? (
            tareas.map((tarea) => (
              <div key={tarea.id} className="mb-3">
                <TarjetaTarea tarea={tarea} onDragStart={onDragStart} />
              </div>
            ))
          ) : (
            <li className="text-muted text-center small">(Sin tareas)</li>
          )}
        </div>
      </div>
    </div>
  );
};

export default ColumnaKanban;
