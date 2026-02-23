import React from "react";
import UserMenu from "../ui/UserMenu";

function Header() {
  return (
    <header className="navbar navbar-expand-lg navbar-light bg-light py-3 px-4 border-bottom">
      <div className="container-fluid d-flex justify-content-between align-items-center">
        <a
          href="/"
          className="navbar-brand fw-bold fs-4 mb-0"
          style={{ textDecoration: "none" }}
        >
          <h4 className="fw-bold text-primary mb-0">TaskFlow</h4>
        </a>
        {/* LOGO */}

        <form className="d-flex flex-grow-1 mx-3" style={{ maxWidth: "500px" }}>
          <input
            className="form-control me-2"
            type="search"
            placeholder="Buscar proyectos, tareas..."
          />
          <button className="btn btn-outline-primary" type="submit">
            Buscar
          </button>
        </form>

        {/* Aquí va el componente */}
        <UserMenu />
      </div>
    </header>
  );
}

export default Header;
