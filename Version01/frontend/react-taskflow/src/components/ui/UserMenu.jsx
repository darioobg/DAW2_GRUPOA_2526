import { useContext, useState, useRef, useEffect } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function UserMenu() {
  const { datos, logOut } = useContext(SeguridadContext);
  const [abierto, setAbierto] = useState(false);
  const menuRef = useRef();
  const coloresRol = {
    ADMIN: "bg-danger",
    COLABORADOR: "bg-success",
    LECTOR: "bg-secondary",
  };
  if (!datos.usuario) return null;

  // 🔹 Obtener iniciales
  const obtenerIniciales = (nombreCompleto) => {
    if (!nombreCompleto) return "U";

    const partes = nombreCompleto.trim().split(" ");
    if (partes.length === 1) return partes[0][0].toUpperCase();

    return partes[0][0].toUpperCase() + partes[1][0].toUpperCase();
  };

  const iniciales = obtenerIniciales(datos.usuario.name);

  // 🔹 Cerrar menú si clic fuera
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (menuRef.current && !menuRef.current.contains(event.target)) {
        setAbierto(false);
      }
    };

    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  return (
    <div className="position-relative" ref={menuRef}>
      {/* Avatar */}
      <div
        className="rounded-circle bg-primary d-flex justify-content-center align-items-center"
        style={{
          width: "40px",
          height: "40px",
          color: "#fff",
          fontWeight: "bold",
          cursor: "pointer",
        }}
        onClick={() => setAbierto(!abierto)}
      >
        {iniciales}
      </div>

      {/* Dropdown */}
      {abierto && (
        <div
          className="position-absolute bg-white shadow rounded p-3"
          style={{
            right: 0,
            top: "50px",
            width: "250px",
            zIndex: 1000,
          }}
        >
          <div className="mb-3">
            <strong>{datos.usuario.name}</strong>
            <div className="text-muted small">{datos.usuario.email}</div>
          </div>

          <span
            className={`badge ${coloresRol[datos.rolActivo] || "bg-primary"}`}
          >
            {datos.rolActivo}
          </span>
          <hr />

          <button
            className="btn btn-sm btn-outline-danger w-100"
            onClick={logOut}
          >
            Cerrar sesión
          </button>
        </div>
      )}
    </div>
  );
}

export default UserMenu;
