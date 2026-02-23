import { useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function AdministracionPage() {
  const { datos } = useContext(SeguridadContext);

  // Datos simulados para demo
  const metricas = {
    proyectosActivos: 4,
    tareasAbiertas: 37,
    tareasVencidas: 5,
    miembrosActivos: 6,
  };

  const proyectos = [
    {
      id: 1,
      nombre: "Sistema de Reservas Médicas",
      estado: "En progreso",
      tareasAbiertas: 12,
      avance: 65,
    },
    {
      id: 2,
      nombre: "Portal de Recursos Humanos",
      estado: "En revisión",
      tareasAbiertas: 8,
      avance: 80,
    },
    {
      id: 2,
      nombre: "App de Control de Inventarios",
      estado: "En revisión",
      tareasAbiertas: 8,
      avance: 80,
    },
    {
      id: 2,
      nombre: "Sistema de Gestión Académica",
      estado: "En revisión",
      tareasAbiertas: 8,
      avance: 80,
    },
    {
      id: 2,
      nombre: "Plataforma de Comercio",
      estado: "En revisión",
      tareasAbiertas: 8,
      avance: 80,
    },
  ];

  return (
    <div className="admin-dashboard-container">
      <h1>Panel de Control - {datos?.equipoActivo?.nombre ?? "Equipos"}</h1>

      {/* MÉTRICAS */}
      <div className="admin-metrics">
        <div className="metric-card">
          <h3>{metricas.proyectosActivos}</h3>
          <p>Proyectos Activos</p>
        </div>

        <div className="metric-card">
          <h3>{metricas.tareasAbiertas}</h3>
          <p>Tareas Abiertas</p>
        </div>

        <div className="metric-card danger">
          <h3>{metricas.tareasVencidas}</h3>
          <p>Tareas Vencidas</p>
        </div>

        <div className="metric-card">
          <h3>{metricas.miembrosActivos}</h3>
          <p>Miembros Activos</p>
        </div>
      </div>

      {/* TABLA PROYECTOS */}
      <div className="admin-projects">
        <h2>Resumen de Proyectos</h2>

        <div className="admin-table-head">
          <div className="col col-4">Proyecto</div>
          <div className="col col-2">Estado</div>
          <div className="col col-2">Tareas Abiertas</div>
          <div className="col col-2">Avance</div>
        </div>

        {proyectos.map((p) => (
          <div key={p.id} className="admin-table-row">
            <div className="col col-4">{p.nombre}</div>
            <div className="col col-2">{p.estado}</div>
            <div className="col col-2">{p.tareasAbiertas}</div>
            <div className="col col-2">{p.avance}%</div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default AdministracionPage;
