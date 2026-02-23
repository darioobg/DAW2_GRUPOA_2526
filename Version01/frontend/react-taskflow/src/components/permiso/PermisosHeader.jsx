// src/components/permiso/PermisosHeader.jsx
export default function PermisosHeader({ onCreate }) {
  return (
    <div className="admin-permisos-header">
      <h1 className="admin-permisos-title">Permisos</h1>

      <button className="btn btn-primary" onClick={onCreate}>
        + Asignar Permiso
      </button>
    </div>
  );
}
