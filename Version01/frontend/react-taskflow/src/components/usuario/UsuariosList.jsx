export default function UsuariosList({
  usuarios,
  loading,
  error,
  onEdit,
  onDelete,
  esAdmin,
}) {
  if (loading) return <div>Cargando usuarios...</div>;
  if (error) return <div className="text-danger">{error}</div>;
  if (usuarios.length === 0) return <div>No hay usuarios.</div>;

  return (
    <div className="usuarios-list">
      <div className="usuarios-header">
        <div>Nombre</div>
        <div>Email</div>
        {esAdmin && <div className="text-center">Acciones</div>}
      </div>

      {usuarios.map((usuario) => (
        <div key={usuario.id} className="usuario-row">
          <div className="usuario-col">{usuario.name}</div>
          <div className="usuario-col">{usuario.email}</div>

          {esAdmin && (
            <div className="usuario-col acciones text-center">
              <button
                className="btn btn-sm btn-outline-primary me-2"
                onClick={() => onEdit(usuario)}
              >
                Editar
              </button>

              <button
                className="btn btn-sm btn-outline-danger"
                onClick={() => onDelete(usuario.id)}
              >
                Eliminar
              </button>
            </div>
          )}
        </div>
      ))}
    </div>
  );
}
