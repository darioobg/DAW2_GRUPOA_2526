import { useEffect, useState } from "react";
import NegocioProyectos from "../../core/Negocio";
import ProyectosDestacados from "../../components/proyecto/ProyectosDestacados";
import ProyectoGrid from "../../components/proyecto/ProyectoGrid";
import ProyectoModal from "../../components/proyecto/ProyectoModal";

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

  async function handleSubmit(payload) {
    try {
      if (modalInitialData?.id) {
        await NegocioProyectos.actualizarProyecto(modalInitialData.id, payload);
      } else {
        await NegocioProyectos.crearProyecto(payload);
      }

      await cargarProyectos();
      setShowModal(false);
      setModalInitialData(null);
    } catch (error) {
      console.error("Error guardando proyecto:", error);
    }
  }

  // Eliminar/archivar proyecto (se ajustó para usar eliminarProyecto)
  const handleArchive = async (id) => {
    try {
      setError(null);
      await NegocioProyectos.eliminarProyecto(id);
      await cargarProyectos();
    } catch (e) {
      console.error(e);
      setError("Error al eliminar el proyecto");
    }
  };

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
        onArchive={handleArchive}
      />

      <ProyectoModal
        show={showModal}
        onClose={() => setShowModal(false)}
        onSubmit={handleSubmit}
        initialData={modalInitialData}
      />
    </>
  );
}

export default DashboardPage;
