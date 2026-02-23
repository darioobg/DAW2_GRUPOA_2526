import { useEffect, useState } from "react";
import NegocioEquipos from "../../core/Negocio";
import EquiposHeader from "../../components/equipo/EquiposHeader";
import EquiposList from "../../components/equipo/EquiposList";
import EquipoModal from "../../components/equipo/EquipoModal";

export default function EquiposPage() {
  const [equipos, setEquipos] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [showModal, setShowModal] = useState(false);
  const [modalInitialData, setModalInitialData] = useState(null);

  useEffect(() => {
    cargarEquipos();
  }, []);

  async function cargarEquipos() {
    try {
      setLoading(true);
      const data = await NegocioEquipos.obtenerEquipos();
      setEquipos(data);
    } catch {
      setError("Error cargando equipos");
    } finally {
      setLoading(false);
    }
  }

  function abrirCrear() {
    setModalInitialData(null);
    setShowModal(true);
  }

  function abrirEditar(equipo) {
    setModalInitialData(equipo);
    setShowModal(true);
  }

  async function eliminarEquipo(id) {
    if (!window.confirm("¿Eliminar equipo?")) return;
    await NegocioEquipos.eliminarEquipo(id);
    await cargarEquipos();
  }

  async function guardarEquipo(payload) {
    if (modalInitialData?.id) {
      await NegocioEquipos.actualizarEquipo(modalInitialData.id, payload);
    } else {
      await NegocioEquipos.crearEquipo(payload);
    }

    setShowModal(false);
    await cargarEquipos();
  }

  return (
    <div className="admin-container">
      <EquiposHeader onCreate={abrirCrear} />

      <EquiposList
        equipos={equipos}
        loading={loading}
        error={error}
        onEdit={abrirEditar}
        onDelete={eliminarEquipo}
      />

      {showModal && (
        <EquipoModal
          initialData={modalInitialData}
          onClose={() => setShowModal(false)}
          onSubmit={guardarEquipo}
        />
      )}
    </div>
  );
}
