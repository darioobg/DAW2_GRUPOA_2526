export default function RolesHeader({ onCreate }) {
  return (
    <div className="admin-header d-flex justify-content-between align-items-center mb-4">
      <h1 className="admin-title">Roles</h1>

      <button className="btn btn-primary" onClick={onCreate}>
        + Crear Rol
      </button>
    </div>
  );
}
