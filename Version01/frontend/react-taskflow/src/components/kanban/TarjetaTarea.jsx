export default function TarjetaTarea({ tarea, onDragStart }) {
  if (!tarea) return null;

  return (
    <div
      draggable={true}
      onDragStart={(e) => {
        console.log("DRAG START tarea:", tarea.id);
        onDragStart(e, tarea.id);
      }}
      style={{
        cursor: "grab",
        userSelect: "none",
      }}
      className="card shadow-sm border border-secondary-subtle mb-2"
    >
      <div className="card-body py-2 px-3">
        <span className="fw-medium">{tarea.titulo}</span>
      </div>
    </div>
  );
}
