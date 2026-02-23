// src/components/dashboard/MisEquiposList.jsx

export default function MisEquiposList({ equipos, loading, error }) {
  if (loading) return <div>Cargando equipos...</div>;
  if (error) return <div className="text-danger">{error}</div>;
  if (!equipos || equipos.length === 0)
    return <div>No perteneces a ningún equipo.</div>;

  return (
    <div className="mis-equipos-table">
      {/* Header */}
      <div className="mis-equipos-table-head">
        <div className="col col-4">Nombre</div>
        <div className="col col-4">Descripción</div>
        <div className="col col-2">Mi Rol</div>
        <div className="col col-2">Fecha Alta</div>
      </div>

      {/* Rows */}
      {equipos.map((equipo) => (
        <div key={equipo.id} className="mis-equipos-row">
          <div className="col col-4">
            <strong>{equipo.nombre}</strong>
          </div>

          <div className="col col-4">{equipo.descripcion ?? "-"}</div>

          <div className="col col-2">
            <span className="badge bg-primary">
              {equipo.miRol?.nombre ?? "Sin rol"}
            </span>
          </div>

          <div className="col col-2">{equipo.fechaAlta ?? "-"}</div>
        </div>
      ))}
    </div>
  );
}
