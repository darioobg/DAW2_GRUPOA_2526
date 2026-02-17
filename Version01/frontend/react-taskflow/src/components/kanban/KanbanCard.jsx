function KanbanCard({ tarea, onDragStart }) {
  return (
    <div
      className="card mb-2"
      draggable
      onDragStart={(e) => onDragStart(e, tarea.id)}
    >
      <div className="card-body">
        <strong>{tarea.titulo}</strong>
      </div>
    </div>
  );
}

export default KanbanCard;
