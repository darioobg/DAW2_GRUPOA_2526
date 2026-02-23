import React from "react";

export default function TableroMenuLateral({
  isOpen,
  onClose,
  proyecto,
  onEdit,
  onArchive,
}) {
  if (!isOpen || !proyecto) return null;

  return (
    <div
      className="drawer"
      style={{
        position: "fixed",
        top: 0,
        right: 0,
        width: "320px",
        height: "100vh",
        background: "#fff",
        boxShadow: "-2px 0 8px rgba(0,0,0,.07)",
        zIndex: 1080,
        display: "flex",
        flexDirection: "column",
        padding: "2rem 1.5rem 1rem 1.5rem",
      }}
    >
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h5 className="fw-bold mb-0" style={{ fontSize: "1.25rem" }}>
          {proyecto.nombre}
        </h5>
        <button
          aria-label="Cerrar menú lateral"
          type="button"
          className="btn-close"
          style={{ fontSize: "1.3rem" }}
          onClick={onClose}
        />
      </div>

      <div className="mb-3">
        <button
          className="btn btn-outline-primary w-100 mb-2 d-flex align-items-center justify-content-center"
          style={{ gap: "7px" }}
          onClick={onEdit}
        >
          <span role="img" aria-label="edit">
            ✏
          </span>{" "}
          Editar proyecto
        </button>
        <button
          className="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center"
          style={{ gap: "7px" }}
          onClick={onArchive}
        >
          <span role="img" aria-label="archive">
            📦
          </span>{" "}
          Archivar proyecto
        </button>
      </div>
    </div>
  );
}
