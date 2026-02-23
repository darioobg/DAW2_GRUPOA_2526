// src/pages/dashboard/MisEquiposPage.jsx

import { useEffect, useState } from "react";
import Negocio from "../../core/Negocio";
import MisEquiposList from "../../components/equipo/MisEquiposList";

export default function MisEquiposPage() {
  const [equipos, setEquipos] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    cargarEquipos();
  }, []);

  async function cargarEquipos() {
    try {
      setLoading(true);
      setError(null);

      const data = await Negocio.obtenerMisEquipos();
      setEquipos(data);
    } catch (err) {
      console.error(err);
      setError("Error cargando mis equipos");
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="mis-equipos-container">
      <div className="mis-equipos-header">
        <h1>Mis Equipos</h1>
      </div>

      <MisEquiposList equipos={equipos} loading={loading} error={error} />
    </div>
  );
}
