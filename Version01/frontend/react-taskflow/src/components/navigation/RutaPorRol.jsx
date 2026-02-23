import { useContext } from "react";
import { Navigate } from "react-router-dom";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function RutaPorRol({ children, rolesPermitidos }) {
  const { datos } = useContext(SeguridadContext);

  if (!datos?.usuario) {
    return <Navigate to="/login" replace />;
  }

  if (!rolesPermitidos.includes(datos.rolActivo)) {
    return <Navigate to="/dashboard" replace />;
  }

  return children;
}

export default RutaPorRol;
