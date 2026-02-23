import React, { useContext } from "react";
import { NavLink } from "react-router-dom";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function Sidebar() {
  const { datos } = useContext(SeguridadContext);

  // Protección mientras carga
  if (!datos?.usuario) return null;

  const isAdmin = datos.rolActivo === "ADMIN";

  return (
    <div
      className={`d-flex flex-column justify-content-between vh-100 p-3 ${
        isAdmin ? "admin-border" : ""
      }`}
      style={{
        minWidth: "250px",
        backgroundColor: "#ffffff",
        borderRight: "1px solid #e5e7eb",
      }}
    >
      <div>
        {/* ===== OPERATIVO ===== */}
        <div className="mb-2 px-2">
          <small className="text-uppercase text-muted fw-bold">Operativo</small>
        </div>

        <ul className="nav nav-pills flex-column gap-1 mb-4">
          <li>
            <NavLink to="/dashboard" className="nav-link">
              <i className="bi bi-house-door me-2"></i> Inicio
            </NavLink>
          </li>
          <li>
            <NavLink to="/dashboard/tableros" className="nav-link">
              <i className="bi bi-kanban me-2"></i>Mis Tableros
            </NavLink>
          </li>
          <li>
            <NavLink to="/dashboard/mis-tareas" className="nav-link">
              <i className="bi bi-check2-square me-2"></i> Mis Tareas
            </NavLink>
          </li>
          <li>
            <NavLink to="/dashboard/mis-equipos" className="nav-link">
              <i className="bi bi-people me-2"></i> Mis Equipos
            </NavLink>
          </li>
        </ul>

        {/* ===== ADMIN ===== */}
        {isAdmin && (
          <>
            <hr />
            <div className="mb-2 px-2">
              <small className="text-uppercase text-muted fw-bold">
                <i className="bi bi-gear-fill me-1"></i> Administración
              </small>
            </div>

            <ul className="nav nav-pills flex-column gap-1">
              <li>
                <NavLink to="/dashboard/operativo" className="nav-link">
                  <i className="bi bi-bar-chart-steps me-2"></i> Vista Operativa
                </NavLink>
              </li>
              <li>
                <NavLink to="/dashboard/admin/usuarios" className="nav-link">
                  <i className="bi bi-person-badge me-2"></i> Usuarios
                </NavLink>
              </li>
              <li>
                <NavLink to="/dashboard/admin/equipos" className="nav-link">
                  <i className="bi bi-people me-2"></i> Equipos
                </NavLink>
              </li>
              <li>
                <NavLink to="/dashboard/admin/roles" className="nav-link">
                  <i className="bi bi-shield-lock me-2"></i> Roles
                </NavLink>
              </li>
              <li>
                <NavLink to="/dashboard/admin/permisos" className="nav-link">
                  <i className="bi bi-lock-fill me-2"></i> Permisos
                </NavLink>
              </li>
            </ul>
          </>
        )}
      </div>

      {/* PERFIL RESUMIDO */}
      <div className="border-top pt-3">
        <div className="fw-bold">{datos.usuario.name}</div>
        {isAdmin && (
          <span className="badge bg-danger">
            <i className="bi bi-shield-lock-fill me-1"></i>ADMIN
          </span>
        )}
      </div>
    </div>
  );
}

export default Sidebar;
