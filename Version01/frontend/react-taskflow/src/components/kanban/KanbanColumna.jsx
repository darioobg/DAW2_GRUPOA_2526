import KanbanCard from "./KanbanCard";

function KanbanColumna({
  columna,
  tareas,
  onDragStart,
  onDrop,
  onDragOver,
  onNuevaTarea,
}) {
  return (
    <div
      className="col-12 col-md-3"
      onDragOver={(e) => e.preventDefault()}
      onDrop={(e) => onDrop(e, columna.key)}
    >
      <h5>{columna.nombre}</h5>
      <button
        className="btn btn-sm btn-outline-primary w-100 mb-2"
        onClick={() => onNuevaTarea(columna.key)}
      >
        + Nueva tarea
      </button>

      {tareas.map((tarea) => (
        <KanbanCard key={tarea.id} tarea={tarea} onDragStart={onDragStart} />
      ))}
    </div>
  );
}

export default KanbanColumna;
