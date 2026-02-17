import KanbanColumna from "./KanbanColumna";
function KanbanBoard({
  columnas,
  tareas,
  getTareasPorColumna,
  onDragStart,
  onDrop,
  onDragOver,
  onNuevaTarea,
}) {
  return (
    <div className="row g-4">
      {columnas.map((columna) => (
        <KanbanColumna
          key={columna.key}
          columna={columna}
          tareas={getTareasPorColumna(columna.key)}
          onDragStart={onDragStart}
          onDrop={onDrop}
          onDragOver={onDragOver}
          onNuevaTarea={onNuevaTarea} // 👈 ESTO FALTABA
        />
      ))}
    </div>
  );
}

export default KanbanBoard;
