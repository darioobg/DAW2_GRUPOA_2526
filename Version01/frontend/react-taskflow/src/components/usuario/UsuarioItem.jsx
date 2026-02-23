export default function UsuarioItem({ usuario, onEdit, onDelete }) {
  return (
    <div className="usuario-row">
      <div className="usuario-col">{usuario.name}</div>
      <div className="usuario-col">{usuario.email}</div>
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
    </div>
  );
}
