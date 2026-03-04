function CrearNuevoTableroCard({ onClick }) {
  return (
    <div
      className="card shadow-sm rounded-4 border-0 w-100 h-100 d-flex flex-column overflow-hidden crear-card"
      onClick={onClick}
      style={{ cursor: "pointer" }}
    >
      {/* HEADER mismo alto que ProyectoCard */}
      <div
        className="d-flex align-items-center justify-content-center flex-grow-0"
        style={{
          height: "140px",
          background: "linear-gradient(135deg, #e5e7eb, #d1d5db)",
        }}
      >
        <i className="bi bi-plus-lg fs-1 text-dark opacity-75"></i>
      </div>

      {/* BODY que ocupa el resto */}
      <div className="card-body d-flex align-items-center justify-content-center flex-grow-1">
        <h6 className="fw-semibold mb-0 text-center">Crear nuevo tablero</h6>
      </div>
    </div>
  );
}

export default CrearNuevoTableroCard;