export default function RolesList({ roles, loading, error, onEdit, onDelete }) {
  if (loading) return <div>Cargando roles...</div>;
  if (error) return <div className="text-danger">{error}</div>;
  if (roles.length === 0) return <div>No hay roles.</div>;

  return (
    <div className="admin-table">
      <div className="admin-table-header">
        <div className="col-6">Nombre</div>
        <div className="col-6 text-center">Acciones</div>
      </div>

      {roles.map((rol) => (
        <div key={rol.id} className="admin-table-row">
          <div className="col-6">{rol.nombre}</div>

          <div className="col-6 text-center">
            <button
              className="btn btn-sm btn-outline-primary me-2"
              onClick={() => onEdit(rol)}
            >
              Editar
            </button>

            <button
              className="btn btn-sm btn-outline-danger"
              onClick={() => onDelete(rol.id)}
            >
              Eliminar
            </button>
          </div>
        </div>
      ))}
    </div>
  );
}
