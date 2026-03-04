import { useNavigate } from "react-router-dom";
import { useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function ProyectoCard({ proyecto, onEdit, onArchive }) {
  const { id, nombre, descripcion, color } = proyecto;
  const navigate = useNavigate();
  const { datos } = useContext(SeguridadContext);

  const esAdmin = datos?.rolActivo === "ADMIN";

  const handleOpen = () => {
    navigate(`/tableros/${id}`);
  };

  const handleArchiveClick = (e) => {
    e.stopPropagation();

    if (
      window.confirm(`¿Archivar "${nombre}"? Esta acción no se puede deshacer.`)
    ) {
      onArchive(id);
    }
  };

  return (
    <div className="card proyecto-card shadow-sm rounded-4 h-100 border-0 overflow-hidden">
      {/* HEADER */}
      <div
        className="proyecto-card-header position-relative d-flex align-items-center justify-content-center"
        style={{
          background: color
            ? `linear-gradient(135deg, ${color}, #5a54f1)`
            : "linear-gradient(135deg, #6c63ff, #5a54f1)",
          height: "100px",
          cursor: "pointer",
        }}
        onClick={handleOpen}
      >
        {/* Letra */}
        <span className="proyecto-card-letter text-white fw-bold">
          {nombre?.charAt(0).toUpperCase()}
        </span>

        {/* Botones ADMIN */}
        {esAdmin && (
          <div className="position-absolute top-0 end-0 p-2 d-flex gap-2">
            <button
              className="btn btn-light btn-sm rounded-circle shadow-sm"
              onClick={(e) => {
                e.stopPropagation();
                onEdit(id);
              }}
            >
              <i className="bi bi-pencil"></i>
            </button>

            <button
              className="btn btn-danger btn-sm rounded-circle shadow-sm"
              onClick={handleArchiveClick}
            >
              <i className="bi bi-archive"></i>
            </button>
          </div>
        )}
      </div>

      {/* BODY */}
      <div className="card-body">
        <h5 className="card-title fw-semibold mb-2">{nombre}</h5>
        <p className="card-text text-muted small mb-0">{descripcion}</p>
      </div>
    </div>
  );
}

export default ProyectoCard;
