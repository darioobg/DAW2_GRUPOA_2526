export default function EquiposList({
  equipos,
  loading,
  error,
  onEdit,
  onDelete,
}) {
  if (loading)
    return (
      <div className="text-center py-5 text-muted">Cargando equipos...</div>
    );

  if (error) return <div className="alert alert-danger rounded-4">{error}</div>;

  if (equipos.length === 0)
    return <div className="text-center py-5 text-muted">No hay equipos.</div>;

  return (
    <div className="p-4 rounded-4" style={{ backgroundColor: "#f3f4f6" }}>
      {/* Header */}
      <div className="row fw-semibold text-muted mb-3 px-3">
        <div className="col-md-4">Nombre</div>
        <div className="col-md-6">Descripción</div>
        <div className="col-md-2 text-center">Acciones</div>
      </div>

      {/* Filas */}
      {equipos.map((equipo) => (
        <div
          key={equipo.id}
          className="row align-items-center py-3 px-3 mb-2 rounded-4"
          style={{
            backgroundColor: "#ffffff",
            transition: "all 0.2s ease",
          }}
        >
          <div className="col-md-4 fw-semibold">{equipo.nombre}</div>

          <div className="col-md-6 text-muted">{equipo.descripcion}</div>

          <div className="col-md-2 text-center">
            <button
              className="btn btn-sm btn-outline-primary rounded-pill px-3 me-2 btn-edit"
              onClick={() => onEdit(equipo)}
            >
              Editar
            </button>

            <button
              className="btn btn-sm btn-outline-danger rounded-pill px-3 btn-delete"
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