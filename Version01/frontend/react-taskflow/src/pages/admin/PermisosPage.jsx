import { useEffect, useState } from "react";

import Negocio from "../../core/Negocio";

import PermisosHeader from "../../components/permiso/PermisosHeader";
import PermisosList from "../../components/permiso/PermisosList";
import PermisoModal from "../../components/permiso/PermisoModal";

export default function PermisosPage() {
  const [permisos, setPermisos] = useState([]);
  const [usuarios, setUsuarios] = useState([]);
  const [equipos, setEquipos] = useState([]);
  const [roles, setRoles] = useState([]);

  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [showModal, setShowModal] = useState(false);
  const [modalInitialData, setModalInitialData] = useState(null);

  useEffect(() => {
    cargarTodo();
  }, []);

  async function cargarTodo() {
    try {
      setError(null);
      setLoading(true);

      const [p, u, e, r] = await Promise.all([
        Negocio.obtenerPermisos(),
        Negocio.obtenerUsuarios(),
        Negocio.obtenerEquipos(),
        Negocio.obtenerRoles(),
      ]);

      setPermisos(p ?? []);
      setUsuarios(u ?? []);
      setEquipos(e ?? []);
      setRoles(r ?? []);
    } catch (err) {
      console.error(err);
      setError("Error cargando permisos / catálogos");
    } finally {
      setLoading(false);
    }
  }

  function abrirCrear() {
    setModalInitialData(null);
    setShowModal(true);
  }

  function abrirEditar(item) {
    setModalInitialData(item);
    setShowModal(true);
  }

  async function eliminarPermiso(item) {
    const ok = window.confirm(
      "¿Eliminar asignación (permiso) del usuario en este equipo?",
    );
    if (!ok) return;

    try {
      setError(null);
      await Negocio.eliminarPermiso(item.idUsuario, item.idEquipo);
      await cargarTodo();
    } catch (err) {
      console.error(err);
      setError("Error eliminando permiso");
    }
  }

  async function guardarPermiso(payload) {
    try {
      setError(null);

      // payload: {idUsuario, idEquipo, idRol, fechaAlta}
      if (modalInitialData) {
        // Editar: normalmente NO cambia idUsuario/idEquipo (PK compuesta)
        await Negocio.actualizarPermiso(
          modalInitialData.idUsuario,
          modalInitialData.idEquipo,
          payload,
        );
      } else {
        await Negocio.crearPermiso(payload);
      }

      setShowModal(false);
      setModalInitialData(null);
      await cargarTodo();
    } catch (err) {
      console.error(err);
      setError("Error guardando permiso");
    }
  }

  return (
    <div className="admin-permisos-container">
      <PermisosHeader onCreate={abrirCrear} />

      <PermisosList
        permisos={permisos}
        usuarios={usuarios}
        equipos={equipos}
        roles={roles}
        loading={loading}
        error={error}
        onEdit={abrirEditar}
        onDelete={eliminarPermiso}
      />

      {showModal && (
        <PermisoModal
          initialData={modalInitialData}
          usuarios={usuarios}
          equipos={equipos}
          roles={roles}
          onClose={() => setShowModal(false)}
          onSubmit={guardarPermiso}
        />
      )}
    </div>
  );
}
