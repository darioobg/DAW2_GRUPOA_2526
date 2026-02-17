function ProyectoDestacadoCard({ proyecto, onEdit }) {
  const {
    nombre = "",
    descripcion = "",
    fecha_inicio = "",
    fecha_fin_prevista = "",
    color = "",
  } = proyecto || {};

  return (
    <div
      className="card h-100 shadow-sm position-relative"
      style={{ minWidth: 260, maxWidth: 280 }}
    >
      <button
        type="button"
        className="btn btn-sm btn-light position-absolute"
        style={{
          top: 8,
          right: 10,
          zIndex: 2,
          borderRadius: "50%",
          padding: "4px 6px",
          border: "none",
        }}
        title="Editar proyecto"
        aria-label="Editar proyecto"
        onClick={onEdit}
      >
        <i className="bi bi-pencil"></i>
      </button>

      <div
        className="card-img-top d-flex align-items-center justify-content-center"
        style={{
          height: 120,
          backgroundColor: color || "#6c63ff",
          borderTopLeftRadius: ".375rem",
          borderTopRightRadius: ".375rem",
        }}
      >
        <span className="fw-bold" style={{ color: "#fff", fontSize: "2rem" }}>
          {nombre ? nombre.charAt(0) : "?"}
        </span>
      </div>

      <div className="card-body pb-2">
        <h5 className="card-title mb-1">{nombre}</h5>
        <p className="card-text text-muted" style={{ fontSize: "0.95rem" }}>
          {descripcion}
        </p>

        <div className="small text-muted mt-2">
          {fecha_inicio && (
            <div>
              <i className="bi bi-calendar-week me-1"></i>
              Inicio: {fecha_inicio}
            </div>
          )}
          {fecha_fin_prevista && (
            <div>
              <i className="bi bi-flag me-1"></i>
              Fin Prevista: {fecha_fin_prevista}
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

export default ProyectoDestacadoCard;
