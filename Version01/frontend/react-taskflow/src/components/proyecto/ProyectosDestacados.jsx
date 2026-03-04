import ProyectoDestacadoCard from "./ProyectoDestacadoCard";

function ProyectosDestacados({ proyectos, loading, error, onEdit }) {
  const destacados = Array.isArray(proyectos) ? proyectos.slice(0, 4) : [];

  return (
    <section className="mb-5">
      <div className="mb-3 d-flex align-items-center justify-content-between">
        <h4 className="fw-bold mb-0">Tableros Destacados</h4>
      </div>

      <div className="d-flex flex-row gap-4 overflow-auto pb-2">
        {loading && <span>Cargando...</span>}
        {error && <span className="text-danger">{error}</span>}

        {!loading &&
          !error &&
          destacados.map((proyecto) => (
            <ProyectoDestacadoCard
              key={proyecto.id}
              proyecto={proyecto}
              onEdit={() => onEdit(proyecto)}
            />
          ))}

        {!loading && !error && destacados.length === 0 && (
          <span className="text-muted">No hay proyectos destacados.</span>
        )}
      </div>
    </section>
  );
}

export default ProyectosDestacados;
