import { useEffect, useState } from "react";
import NegocioProyectos from "../core/Negocio";
import ProyectosDestacados from "../components/ProyectosDestacados";
import ProyectoGrid from "../components/ProyectoGrid";
import ProyectoModal from "../components/ProyectoModal";

function DashboardPage() {
  const [proyectos, setProyectos] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [showModal, setShowModal] = useState(false);
  const [modalInitialData, setModalInitialData] = useState(null);

  useEffect(() => {
    cargarProyectos();
  }, []);

  async function cargarProyectos() {
    try {
      const data = await NegocioProyectos.obtenerProyectos();
      setProyectos(data);
    } catch {
      setError("Error cargando proyectos");
    } finally {
      setLoading(false);
    }
  }

  function openCreateModal() {
    setModalInitialData(null);
    setShowModal(true);
  }

  function openEditModal(proyecto) {
    setModalInitialData(proyecto);
    setShowModal(true);
  }

  return (
    <>
      <ProyectosDestacados
        proyectos={proyectos}
        loading={loading}
        error={error}
        onEdit={openEditModal}
      />

      <ProyectoGrid
        proyectos={proyectos}
        loading={loading}
        error={error}
        onCreate={openCreateModal}
        onEdit={openEditModal}
      />

      <ProyectoModal
        show={showModal}
        onClose={() => setShowModal(false)}
        initialData={modalInitialData}
      />
    </>
  );
}

export default DashboardPage;
