import { useEffect, useState, useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";
import NegocioProyectos from "../../core/Negocio";
import ProyectoGrid from "../../components/proyecto/ProyectoGrid";
import ProyectoModal from "../../components/proyecto/ProyectoModal";

function DashboardPage() {
  const { datos } = useContext(SeguridadContext);

  const esAdmin = datos?.rolActivo === "ADMIN";

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
      const data = await NegocioProyectos.obtenerMisProyectos();
      setProyectos(data);
    } catch {
      setError("Error cargando proyectos");
    } finally {
      setLoading(false);
    }
  }

  function openCreateModal() {
    if (!esAdmin) return;
    setModalInitialData(null);
    setShowModal(true);
  }

  function openEditModal(proyecto) {
    if (!esAdmin) return;
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

  const handleArchive = async (id) => {
    if (!esAdmin) return;

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
      {/* Grid completo */}
      <ProyectoGrid
        proyectos={proyectos}
        loading={loading}
        error={error}
        onCreate={esAdmin ? openCreateModal : null}
        onEdit={esAdmin ? openEditModal : null}
        onArchive={esAdmin ? handleArchive : null}
        esAdmin={esAdmin}
      />

      {/* Modal solo para admin */}
      {esAdmin && (
        <ProyectoModal
          show={showModal}
          onClose={() => setShowModal(false)}
          onSubmit={handleSubmit}
          initialData={modalInitialData}
        />
      )}
    </>
  );
}

export default DashboardPage;
