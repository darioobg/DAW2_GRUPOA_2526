function CrearNuevoTableroCard({ onClick }) {
  return (
    <div
      className="card h-100 d-flex justify-content-center align-items-center"
      style={{
        cursor: "pointer",
        border: "2px dashed #b2bec3",
        color: "#636e72",
        minHeight: 170,
      }}
      onClick={onClick}
    >
      <div className="text-center">
        <i className="bi bi-plus-circle fs-1 mb-2"></i>
        <div className="fw-bold">Crear nuevo tablero</div>
      </div>
    </div>
  );
}

export default CrearNuevoTableroCard;
