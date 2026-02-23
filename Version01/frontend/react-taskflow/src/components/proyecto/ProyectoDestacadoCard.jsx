import { useNavigate } from "react-router-dom";
import { useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function ProyectoDestacadoCard({ proyecto, onEdit }) {
  const navigate = useNavigate();
  const { datos } = useContext(SeguridadContext);

  const esAdmin = datos?.rolActivo === "ADMIN";

  const {
    id,
    nombre = "",
    descripcion = "",
    fecha_inicio = "",
    fecha_fin_prevista = "",
    color = "",
  } = proyecto || {};

  const handleOpen = () => {
    navigate(`/tableros/${id}`);
  };

  return (
    <div className="card proyecto-card proyecto-destacado shadow-sm h-100 position-relative">
      {/* Editar: solo visible para ADMIN */}
      {esAdmin && (
        <button
          type="button"
          className="btn btn-light btn-sm proyecto-edit-btn"
          title="Editar proyecto"
          onClick={() => onEdit(id)}
        >
          <i className="bi bi-pencil"></i>
        </button>
      )}

      {/* Header color */}
      <div
        className="proyecto-card-header"
        style={{ backgroundColor: color || "#6c63ff" }}
        onClick={handleOpen}
      >
        <span className="proyecto-card-letter">
          {nombre ? nombre.charAt(0) : "?"}
        </span>
      </div>

      <div className="card-body">
        <h5 className="card-title mb-1">{nombre}</h5>

        <p className="card-text text-muted descripcion-truncada">
          {descripcion}
        </p>

        <div className="project-dates mt-3">
          {fecha_inicio && (
            <div>
              <i className="bi bi-calendar-week me-2"></i>
              <span>{fecha_inicio}</span>
            </div>
          )}

          {fecha_fin_prevista && (
            <div>
              <i className="bi bi-flag me-2"></i>
              <span>{fecha_fin_prevista}</span>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

export default ProyectoDestacadoCard;
