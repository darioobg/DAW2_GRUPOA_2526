import { useState, useEffect } from "react";
import Negocio from "../../core/Negocio";

export default function ModalDetalleTarea({
  tarea,
  onClose,
  onActualizar,
  onEliminar,
}) {
  const [titulo, setTitulo] = useState(tarea.titulo || "");
  const [descripcion, setDescripcion] = useState(tarea.descripcion || "");
  const [idPrioridad, setIdPrioridad] = useState(tarea.idPrioridad || "");
  const [idAsignadoA, setIdAsignadoA] = useState(tarea.idAsignadoA || "");
  const [fechaLimite, setFechaLimite] = useState(
    formatearFechaParaInput(tarea.fechaLimite),
  );

  const [usuarios, setUsuarios] = useState([]);
  const [prioridades, setPrioridades] = useState([]);

  useEffect(() => {
    async function cargarDatos() {
      const usuariosData = await Negocio.obtenerUsuarios();
      const prioridadesData = await Negocio.obtenerPrioridades();

      setUsuarios(usuariosData || []);
      setPrioridades(prioridadesData || []);
    }

    cargarDatos();
  }, []);
  function formatearFechaParaInput(fecha) {
    if (!fecha) return "";
    return fecha.split("T")[0];
  }
  function handleGuardar() {
    const hoy = new Date().toISOString().split("T")[0];

    onActualizar({
      id: tarea.id,
      titulo,
      descripcion,
      id_proyecto: tarea.idProyecto,
      id_estado: tarea.idEstado,
      id_prioridad: idPrioridad,
      id_asignado_a: idAsignadoA,
      fecha_limite: fechaLimite,
      orden_kanban: tarea.ordenKanban,
    });

    onClose();
  }

  return (
    <div
      className="modal show d-block"
      style={{ background: "rgba(0,0,0,0.5)" }}
    >
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h5>Detalle tarea</h5>
            <button onClick={onClose} className="btn-close"></button>
          </div>

          <div className="modal-body">
            <div className="mb-3">
              <label>Título</label>
              <input
                className="form-control"
                value={titulo}
                onChange={(e) => setTitulo(e.target.value)}
              />
            </div>

            <div className="mb-3">
              <label>Descripción</label>
              <textarea
                className="form-control"
                value={descripcion}
                onChange={(e) => setDescripcion(e.target.value)}
              />
            </div>

            <div className="mb-3">
              <label>Prioridad</label>
              <select
                className="form-control"
                value={idPrioridad}
                onChange={(e) => setIdPrioridad(e.target.value)}
              >
                <option value="">Seleccione</option>
                {prioridades.map((p) => (
                  <option key={p.id} value={p.id}>
                    {p.nombre}
                  </option>
                ))}
              </select>
            </div>

            <div className="mb-3">
              <label>Asignado a</label>
              <select
                className="form-control"
                value={idAsignadoA}
                onChange={(e) => setIdAsignadoA(e.target.value)}
              >
                <option value="">Seleccione</option>
                {usuarios.map((u) => (
                  <option key={u.id} value={u.id}>
                    {u.name} {u.apellidos}
                  </option>
                ))}
              </select>
            </div>

            <div className="mb-3">
              <label>Fecha límite</label>
              <input
                type="date"
                className="form-control"
                value={fechaLimite}
                onChange={(e) => setFechaLimite(e.target.value)}
              />
            </div>

            <div className="d-flex justify-content-between">
              <button className="btn btn-success" onClick={handleGuardar}>
                Guardar
              </button>

              <button
                className="btn btn-danger"
                onClick={() => {
                  onEliminar(tarea.id);
                  onClose();
                }}
              >
                Eliminar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
