import React from "react";

function Sidebar() {
  return (
    <div
      className="d-flex flex-column justify-content-between bg-light vh-100 sidebar p-3"
      style={{
        minWidth: "230px",
        maxWidth: "260px",
        borderRight: "1px solid #e5e5e5",
      }}
    >
      {/* Sidebar Top (Logo & Navigation) */}
      <div>
        <div className="mb-5 d-flex align-items-center px-2">
          <span className="fs-3 fw-bold text-primary">TaskFlow</span>
        </div>
        <nav>
          <ul className="nav nav-pills flex-column gap-2">
            <li className="nav-item">
              <a className="nav-link active" href="#">
                <i className="bi bi-house-door me-2"></i> Inicio
              </a>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="#">
                <i className="bi bi-kanban me-2"></i> Tableros
              </a>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="#">
                <i className="bi bi-check-square me-2"></i> Mis Tareas
              </a>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="#">
                <i className="bi bi-people me-2"></i> Equipos
              </a>
            </li>
          </ul>
        </nav>
      </div>

      {/* Sidebar Bottom (Invite Button) */}
      <div className="mt-4 px-2">
        <button className="btn btn-primary w-100">
          <i className="bi bi-person-plus-fill me-2"></i>
          Invitar Miembro
        </button>
      </div>
    </div>
  );
}

export default Sidebar;
