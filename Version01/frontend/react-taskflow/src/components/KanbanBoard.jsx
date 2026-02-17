function KanbanBoard({ proyectos }) {
  return (
    <div className="kanban">
      {proyectos.map((p) => (
        <div key={p.id} className="kanban-card">
          <h4>{p.nombre}</h4>
        </div>
      ))}
    </div>
  );
}

export default KanbanBoard;
