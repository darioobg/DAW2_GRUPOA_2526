export default function EquiposList({
  equipos,
  loading,
  error,
  onEdit,
  onDelete,
}) {
  if (loading) return <div>Cargando equipos...</div>;
  if (error) return <div className="text-danger">{error}</div>;
  if (equipos.length === 0) return <div>No hay equipos.</div>;

  return (
    <div className="admin-table">
      {/* Header */}
      <div className="admin-table-header">
        <div className="col-4">Nombre</div>
        <div className="col-6">Descripción</div>
        <div className="col-2 text-center">Acciones</div>
      </div>

      {/* Filas */}
      {equipos.map((equipo) => (
        <div key={equipo.id} className="admin-table-row">
          <div className="col-4">{equipo.nombre}</div>
          <div className="col-6">{equipo.descripcion}</div>

          <div className="col-2 text-center">
            <button
              className="btn btn-sm btn-outline-primary me-2"
              onClick={() => onEdit(equipo)}
            >
              Editar
            </button>

            <button
              className="btn btn-sm btn-outline-danger"
              onClick={() => onDelete(equipo.id)}
            >
              Eliminar
            </button>
          </div>
        </div>
      ))}
    </div>
  );
}
