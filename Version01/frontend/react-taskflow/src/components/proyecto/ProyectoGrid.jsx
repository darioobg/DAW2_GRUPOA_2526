import { useContext } from "react";
import ProyectoCard from "./ProyectoCard";
import CrearNuevoTableroCard from "./CrearNuevoTableroCard";
import { SeguridadContext } from "../../contexts/SeguridadProvider";

function ProyectoGrid({
  proyectos,
  loading,
  error,
  onCreate,
  onEdit,
  onArchive,
}) {
  const { datos } = useContext(SeguridadContext);
  const esAdmin = datos?.rolActivo === "ADMIN";

  return (
    <section className="mt-3">
      <div className="mb-4">
        <h4 className="fw-bold mb-0">Tus Espacios de Trabajo</h4>
      </div>

      <div className="row g-4">
        {/* Card Crear */}
        {esAdmin && (
          <div className="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
            <CrearNuevoTableroCard onClick={onCreate} />
          </div>
        )}

        {/* Loading */}
        {loading && (
          <div className="col-12">
            <div
              className="p-5 rounded-4 text-center text-muted"
              style={{ backgroundColor: "#f3f4f6" }}
            >
              Cargando proyectos...
            </div>
          </div>
        )}

        {/* Error */}
        {error && (
          <div className="col-12">
            <div
              className="p-5 rounded-4 text-center text-danger"
              style={{ backgroundColor: "#f3f4f6" }}
            >
              {error}
            </div>
          </div>
        )}

        {/* Proyectos */}
        {!loading &&
          !error &&
          proyectos &&
          proyectos.length > 0 &&
          proyectos.map((proyecto) => (
            <div
              key={proyecto.id}
              className="col-12 col-sm-6 col-md-4 col-lg-3 d-flex"
            >
              <ProyectoCard
                proyecto={proyecto}
                onEdit={() => onEdit(proyecto)}
                onArchive={() => onArchive(proyecto.id)}
              />
            </div>
          ))}

        {/* Vacío */}
        {!loading && !error && proyectos && proyectos.length === 0 && (
          <div className="col-12">
            <div
              className="p-5 rounded-4 text-center text-muted"
              style={{ backgroundColor: "#f3f4f6" }}
            >
              Aún no tienes proyectos.
            </div>
          </div>
        )}
      </div>
    </section>
  );
}

export default ProyectoGrid;
