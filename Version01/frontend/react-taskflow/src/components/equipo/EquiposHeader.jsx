export default function EquiposHeader({ onCreate }) {
  return (
    <div className="admin-header d-flex justify-content-between align-items-center mb-4">
      <h1 className="admin-title">Equipos</h1>

      <button className="btn btn-primary" onClick={onCreate}>
        + Crear Equipo
      </button>
    </div>
  );
}
