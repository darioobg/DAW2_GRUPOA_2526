import { useEffect, useState } from "react";
import NegocioRoles from "../../core/Negocio";
import RolesHeader from "../../components/rol/RolesHeader";
import RolesList from "../../components/rol/RolesList";
import RolModal from "../../components/rol/RolModal";

export default function RolesPage() {
  const [roles, setRoles] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [showModal, setShowModal] = useState(false);
  const [modalInitialData, setModalInitialData] = useState(null);

  useEffect(() => {
    cargarRoles();
  }, []);

  async function cargarRoles() {
    try {
      setLoading(true);
      const data = await NegocioRoles.obtenerRoles();
      setRoles(data);
    } catch {
      setError("Error cargando roles");
    } finally {
      setLoading(false);
    }
  }

  function abrirCrear() {
    setModalInitialData(null);
    setShowModal(true);
  }

  function abrirEditar(rol) {
    setModalInitialData(rol);
    setShowModal(true);
  }

  async function eliminarRol(id) {
    if (!window.confirm("¿Eliminar rol?")) return;
    await NegocioRoles.eliminarRol(id);
    await cargarRoles();
  }

  async function guardarRol(payload) {
    if (modalInitialData?.id) {
      await NegocioRoles.actualizarRol(modalInitialData.id, payload);
    } else {
      await NegocioRoles.crearRol(payload);
    }

    setShowModal(false);
    await cargarRoles();
  }

  return (
    <div className="admin-container">
      <RolesHeader onCreate={abrirCrear} />

      <RolesList
        roles={roles}
        loading={loading}
        error={error}
        onEdit={abrirEditar}
        onDelete={eliminarRol}
      />

      {showModal && (
        <RolModal
          initialData={modalInitialData}
          onClose={() => setShowModal(false)}
          onSubmit={guardarRol}
        />
      )}
    </div>
  );
}
