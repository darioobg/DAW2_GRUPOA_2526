import { useContext } from "react";
import { Navigate } from "react-router-dom";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function RutaPrivada({ children }) {
  const { datos, cargando } = useContext(SeguridadContext);

  // Esperar a que termine de restaurar sesión
  if (cargando) {
    return (
      <div className="d-flex justify-content-center align-items-center vh-100">
        <div className="spinner-border text-primary" role="status" />
      </div>
    );
  }

  //  No autenticado
  if (!datos?.usuario) {
    return <Navigate to="/login" replace />;
  }

  return children;
}

export default RutaPrivada;
