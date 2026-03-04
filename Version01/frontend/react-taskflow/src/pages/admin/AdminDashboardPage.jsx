import { useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function AdministracionPage() {
  const { datos } = useContext(SeguridadContext);

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
      id: 3,
      nombre: "App de Control de Inventarios",
      estado: "En progreso",
      tareasAbiertas: 5,
      avance: 40,
    },
    {
      id: 4,
      nombre: "Sistema de Gestión Académica",
      estado: "Completado",
      tareasAbiertas: 0,
      avance: 100,
    },
  ];

  const getEstadoBadge = (estado) => {
    switch (estado) {
      case "En progreso":
        return "bg-primary";
      case "En revisión":
        return "bg-warning text-dark";
      case "Completado":
        return "bg-success";
      default:
        return "bg-secondary";
    }
  };

  return (
    <div className="container py-4">
      <h2 className="mb-4">
        Panel de Control – {datos?.equipoActivo?.nombre ?? "Equipos"}
      </h2>

      {/* MÉTRICAS */}
      <div className="row g-4 mb-5">
        <div className="col-md-3">
          <div className="card border-0 shadow-sm rounded-4 metric-card">
            <div className="card-body text-center">
              <div className="metric-icon bg-primary-subtle text-primary mb-3">
                <i className="bi bi-kanban"></i>
              </div>
              <h3 className="fw-bold text-primary">
                {metricas.proyectosActivos}
              </h3>
              <p className="mb-0 text-muted">Proyectos Activos</p>
            </div>
          </div>
        </div>

        <div className="col-md-3">
          <div className="card border-0 shadow-sm rounded-4 metric-card">
            <div className="card-body text-center">
              <div className="metric-icon bg-light text-dark mb-3">
                <i className="bi bi-list-task"></i>
              </div>
              <h3 className="fw-bold">{metricas.tareasAbiertas}</h3>
              <p className="mb-0 text-muted">Tareas Abiertas</p>
            </div>
          </div>
        </div>

        <div className="col-md-3">
          <div className="card border-0 shadow-sm rounded-4 metric-card">
            <div className="card-body text-center">
              <div className="metric-icon bg-danger-subtle text-danger mb-3">
                <i className="bi bi-exclamation-circle"></i>
              </div>
              <h3 className="fw-bold text-danger">{metricas.tareasVencidas}</h3>
              <p className="mb-0 text-muted">Tareas Vencidas</p>
            </div>
          </div>
        </div>

        <div className="col-md-3">
          <div className="card border-0 shadow-sm rounded-4 metric-card">
            <div className="card-body text-center">
              <div className="metric-icon bg-success-subtle text-success mb-3">
                <i className="bi bi-people"></i>
              </div>
              <h3 className="fw-bold">{metricas.miembrosActivos}</h3>
              <p className="mb-0 text-muted">Miembros Activos</p>
            </div>
          </div>
        </div>
      </div>

      {/* TABLA PROYECTOS */}
      <div className="card border-0 shadow-sm rounded-4">
        <div className="card-body">
          <div className="d-flex justify-content-between align-items-center mb-4">
            <h5 className="mb-0 fw-semibold">Resumen de Proyectos</h5>
          </div>

          <div className="table-responsive">
            <table className="table align-middle">
              <thead className="text-muted small">
                <tr>
                  <th>Proyecto</th>
                  <th>Estado</th>
                  <th className="text-center">Tareas</th>
                  <th>Avance</th>
                </tr>
              </thead>

              <tbody>
                {proyectos.map((p) => (
                  <tr key={p.id} className="border-0">
                    <td className="fw-semibold">{p.nombre}</td>

                    <td>
                      <span
                        className={`badge rounded-pill px-3 py-2 ${getEstadoBadge(p.estado)}`}
                      >
                        {p.estado}
                      </span>
                    </td>

                    <td className="text-center">
                      <span className="badge bg-light text-dark border">
                        {p.tareasAbiertas}
                      </span>
                    </td>

                    <td style={{ minWidth: "160px" }}>
                      <div
                        className="progress rounded-pill"
                        style={{ height: "8px" }}
                      >
                        <div
                          className="progress-bar bg-primary"
                          style={{ width: `${p.avance}%` }}
                        ></div>
                      </div>
                      <small className="text-muted">
                        {p.avance}% completado
                      </small>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  );
}

export default AdministracionPage;