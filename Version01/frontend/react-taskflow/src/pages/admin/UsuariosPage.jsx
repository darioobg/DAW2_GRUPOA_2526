import { useEffect, useState, useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";
import NegocioUsuarios from "../../core/Negocio";
import UsuariosHeader from "../../components/usuario/UsuariosHeader";
import UsuariosList from "../../components/usuario/UsuariosList";
import UsuarioModal from "../../components/usuario/UsuarioModal";

export default function UsuariosPage() {
  const { datos } = useContext(SeguridadContext);
  const esAdmin = datos?.rolActivo === "ADMIN";

  const [usuarios, setUsuarios] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [showModal, setShowModal] = useState(false);
  const [modalInitialData, setModalInitialData] = useState(null);

  useEffect(() => {
    cargarUsuarios();
  }, []);

  async function cargarUsuarios() {
    try {
      setLoading(true);
      const data = await NegocioUsuarios.obtenerUsuarios();
      setUsuarios(data);
    } catch {
      setError("Error cargando usuarios");
    } finally {
      setLoading(false);
    }
  }

  function abrirCrear() {
    if (!esAdmin) return;
    setModalInitialData(null);
    setShowModal(true);
  }

  function abrirEditar(usuario) {
    if (!esAdmin) return;
    setModalInitialData(usuario);
    setShowModal(true);
  }

  async function eliminarUsuario(id) {
    if (!esAdmin) return;
    if (!window.confirm("¿Eliminar usuario?")) return;

    await NegocioUsuarios.eliminarUsuario(id);
    await cargarUsuarios();
  }

  async function guardarUsuario(payload) {
    if (!esAdmin) return;

    if (modalInitialData?.id) {
      await NegocioUsuarios.actualizarUsuario(modalInitialData.id, payload);
    } else {
      await NegocioUsuarios.crearUsuario(payload);
    }

    setShowModal(false);
    await cargarUsuarios();
  }

  return (
    <div className="usuarios-container">
      {/* Header solo visible si es admin */}
      {esAdmin && <UsuariosHeader onCreate={abrirCrear} />}

      <UsuariosList
        usuarios={usuarios}
        loading={loading}
        error={error}
        onEdit={esAdmin ? abrirEditar : null}
        onDelete={esAdmin ? eliminarUsuario : null}
        esAdmin={esAdmin}
      />

      {showModal && esAdmin && (
        <UsuarioModal
          initialData={modalInitialData}
          onClose={() => setShowModal(false)}
          onSubmit={guardarUsuario}
        />
      )}
    </div>
  );
}
