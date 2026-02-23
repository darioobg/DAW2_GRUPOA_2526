function findNombreById(lista, id, key = "id", campo = "nombre") {
  const item = lista?.find((x) => String(x[key]) === String(id));
  return item?.[campo] ?? `#${id}`;
}

export default function PermisosList({
  permisos,
  usuarios,
  equipos,
  roles,
  loading,
  error,
  onEdit,
  onDelete,
}) {
  if (loading) return <div>Cargando permisos...</div>;
  if (error) return <div className="text-danger">{error}</div>;
  if (!permisos || permisos.length === 0)
    return <div>No hay permisos asignados.</div>;

  return (
    <div className="admin-permisos-table">
      <div className="admin-permisos-table-head">
        <div className="c1">Usuario</div>
        <div className="c2">Equipo</div>
        <div className="c3">Rol</div>
        <div className="c4">Fecha Alta</div>
        <div className="c5 text-center">Acciones</div>
      </div>

      {permisos.map((p) => (
        <div
          key={`${p.idUsuario}-${p.idEquipo}`}
          className="admin-permisos-row"
        >
          <div className="c1">
            {findNombreById(usuarios, p.idUsuario, "id", "nombre")}
          </div>
          <div className="c2">
            {findNombreById(equipos, p.idEquipo, "id", "nombre")}
          </div>
          <div className="c3">
            {findNombreById(roles, p.idRol, "id", "nombre")}
          </div>
          <div className="c4">{p.fechaAlta ?? "-"}</div>

          <div className="c5 text-center">
            <button
              className="btn btn-sm btn-outline-primary me-2"
              onClick={() => onEdit(p)}
            >
              Editar
            </button>
            <button
              className="btn btn-sm btn-outline-danger"
              onClick={() => onDelete(p)}
            >
              Eliminar
            </button>
          </div>
        </div>
      ))}
    </div>
  );
}
