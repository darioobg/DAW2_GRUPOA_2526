import TareaForm from "./TareaForm";

export default function TareaModal({
  show,
  onClose,
  idProyecto,
  idEstado,
  onSubmit,
}) {
  if (!show) return null;

  return (
    <div
      className="modal show d-block"
      style={{ background: "rgba(0,0,0,0.5)" }}
    >
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">Nueva Tarea</h5>
            <button
              type="button"
              className="btn-close"
              onClick={onClose}
            ></button>
          </div>

          <div className="modal-body">
            <TareaForm
              idProyecto={idProyecto}
              idEstado={idEstado}
              onSubmit={onSubmit}
            />
          </div>
        </div>
      </div>
    </div>
  );
}
