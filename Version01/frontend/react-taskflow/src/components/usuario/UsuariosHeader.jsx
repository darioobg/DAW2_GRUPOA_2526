export default function UsuariosHeader({ onCreate }) {
  return (
    <div className="usuarios-header-top">
      <h1>Usuarios</h1>
      <button className="btn btn-primary" onClick={onCreate}>
        + Crear Usuario
      </button>
    </div>
  );
}
