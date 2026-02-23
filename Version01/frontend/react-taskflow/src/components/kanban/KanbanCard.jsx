function KanbanCard({ tarea, onDragStart, onAbrirDetalle }) {
  return (
    <div
      className="card mb-2"
      draggable
      onDragStart={(e) => onDragStart(e, tarea.id)}
      onClick={() => onAbrirDetalle && onAbrirDetalle(tarea)}
      style={{ cursor: onAbrirDetalle ? "pointer" : undefined }}
    >
      <div className="card-body">
        <strong>{tarea.titulo}</strong>
      </div>
    </div>
  );
}

export default KanbanCard;
