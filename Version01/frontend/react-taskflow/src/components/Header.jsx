import React from "react";

function Header() {
  return (
    <header className="navbar navbar-expand-lg navbar-light bg-light py-3 px-4 border-bottom">
      <div className="container-fluid d-flex justify-content-between align-items-center">
        {/* Left: Logo or Title (could be replaced by a logo) */}
        <span className="navbar-brand fw-bold fs-4 mb-0">TaskFlow</span>

        {/* Center: Search Bar */}
        <form className="d-flex flex-grow-1 mx-3" style={{ maxWidth: "500px" }}>
          <input
            className="form-control me-2"
            type="search"
            placeholder="Buscar proyectos, tareas..."
            aria-label="Buscar"
          />
          <button className="btn btn-outline-primary" type="submit">
            Buscar
          </button>
        </form>

        {/* Right: User Profile Placeholder */}
        <div className="d-flex align-items-center">
          <div
            className="rounded-circle bg-secondary d-flex justify-content-center align-items-center"
            style={{
              width: "40px",
              height: "40px",
              color: "#fff",
              fontWeight: "bold",
              fontSize: "1.1rem",
            }}
          >
            {/* Initials or user icon placeholder */}
            <span>U</span>
          </div>
        </div>
      </div>
    </header>
  );
}

export default Header;
