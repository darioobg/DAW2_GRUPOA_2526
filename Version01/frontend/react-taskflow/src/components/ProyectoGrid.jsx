import ProyectoCard from "./ProyectoCard";
import CrearNuevoTableroCard from "./CrearNuevoTableroCard";

function ProyectoGrid({ proyectos, loading, error, onCreate, onEdit }) {
  return (
    <section>
      <div className="mb-3 d-flex align-items-center justify-content-between">
        <h4 className="fw-bold mb-0">Tus Espacios de Trabajo</h4>
      </div>

      <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        {/* Card Crear */}
        <div className="col">
          <CrearNuevoTableroCard onClick={onCreate} />
        </div>

        {/* Estados */}
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

        {/* Lista proyectos */}
        {!loading &&
          !error &&
          proyectos.map((proyecto) => (
            <div key={proyecto.id} className="col">
              <ProyectoCard
                proyecto={proyecto}
                onEdit={() => onEdit(proyecto)}
              />
            </div>
          ))}
      </div>
    </section>
  );
}

export default ProyectoGrid;
