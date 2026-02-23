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

  const handleArchiveClick = () => {
    if (!onArchive) return;

    if (
      window.confirm(`¿Archivar "${nombre}"? Esta acción no se puede deshacer.`)
    ) {
      onArchive(id);
    }
  };

  return (
    <div className="card proyecto-card shadow-sm h-100 position-relative">
      {/* Editar: solo visible para ADMIN */}
      {esAdmin && (
        <button
          className="btn btn-light btn-sm proyecto-edit-btn"
          onClick={() => onEdit(id)}
        >
          <i className="bi bi-pencil"></i>
        </button>
      )}

      {/* Archivar: solo visible para ADMIN */}
      {esAdmin && (
        <button
          className="btn btn-danger btn-sm proyecto-archive-btn"
          onClick={handleArchiveClick}
        >
          <i className="bi bi-archive"></i>
        </button>
      )}

      {/* Imagen clickable */}
      <div
        className="proyecto-card-header"
        style={{ backgroundColor: color || "#6c63ff" }}
        onClick={handleOpen}
      >
        <span className="proyecto-card-letter">{nombre?.charAt(0)}</span>
      </div>

      <div className="card-body">
        <h5 className="card-title">{nombre}</h5>
        <p className="card-text text-muted">{descripcion}</p>
      </div>
    </div>
  );
}

export default ProyectoCard;
