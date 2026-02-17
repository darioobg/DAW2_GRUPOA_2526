import { useNavigate, Link } from "react-router-dom";

function ProyectoCard({ proyecto, onEdit }) {
  const { id = 0, nombre = "", descripcion = "", color = "" } = proyecto;

  const navegar = useNavigate();

  // Navegación con parámetro visible en URL
  const handleClick = () => {
    navegar(`/tableros/${id}`);
  };

  // Navegación usando state (sin parámetro visible)
  const handleClickState = () => {
    navegar("/tablerosstate", { state: { idTablero: id } });
  };

  return (
    <div className="card shadow-sm h-100 position-relative">
      {/* Botón editar */}
      <button
        className="btn btn-light btn-sm position-absolute"
        style={{ top: 8, right: 8 }}
        onClick={onEdit}
      >
        <i className="bi bi-pencil"></i>
      </button>

      {/* Click principal */}
      <div
        className="card-img-top d-flex align-items-center justify-content-center"
        style={{
          height: 120,
          backgroundColor: color || "#6c63ff",
          cursor: "pointer",
        }}
        onClick={handleClick}
      >
        <span style={{ color: "#fff", fontSize: "2rem", fontWeight: "bold" }}>
          {nombre?.charAt(0)}
        </span>
      </div>

      <div className="card-body">
        <h5>{nombre}</h5>
        <p className="text-muted">{descripcion}</p>

        {/* Forma Link (JSX) */}
        <Link to={`/tableros/${id}`}>Ver tablero (Link)</Link>

        <br />

        {/* Forma Link con state */}
        <Link to="/tablerosstate" state={{ idTablero: id }}>
          Ver tablero (State)
        </Link>

        <br />

        {/* Botón useNavigate */}
        <button onClick={handleClick}>Navegar con useNavigate</button>

        <button onClick={handleClickState}>Navegar con State</button>
      </div>
    </div>
  );
}

export default ProyectoCard;
