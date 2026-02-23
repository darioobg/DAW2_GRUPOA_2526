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
    <section>
      <div className="mb-3 d-flex align-items-center justify-content-between">
        <h4 className="fw-bold mb-0">Tus Espacios de Trabajo</h4>
      </div>

      <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        {/* Solo los administradores ven la card para crear tablero */}
        {esAdmin && (
          <div className="col">
            <CrearNuevoTableroCard onClick={onCreate} />
          </div>
        )}

        {loading && (
          <div className="col">
            <div className="text-muted py-4">Cargando proyectos...</div>
          </div>
        )}

        {error && (
          <div className="col">
            <div className="text-danger py-4">{error}</div>
          </div>
        )}

        {!loading &&
          !error &&
          proyectos &&
          proyectos.length > 0 &&
          proyectos.map((proyecto) => (
            <div key={proyecto.id} className="col">
              <ProyectoCard
                proyecto={proyecto}
                onEdit={() => onEdit(proyecto)}
                onArchive={() => onArchive(proyecto.id)}
              />
            </div>
          ))}

        {!loading && !error && proyectos && proyectos.length === 0 && (
          <div className="col">
            <div className="text-muted py-4">Aún no tienes proyectos.</div>
          </div>
        )}
      </div>
    </section>
  );
}

export default ProyectoGrid;
