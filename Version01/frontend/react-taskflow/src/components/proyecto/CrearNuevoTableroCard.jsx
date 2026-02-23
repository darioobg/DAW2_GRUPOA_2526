function CrearNuevoTableroCard({ onClick }) {
  return (
    <div
      className="card h-100 d-flex justify-content-center align-items-center nuevo"
    
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
