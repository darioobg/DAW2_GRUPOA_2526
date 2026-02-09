import ProyectoForm from "./ProyectoForm";

export default function ProyectoModal({
  show,
  onClose,
  onSubmit,
  initialData,
}) {
  if (!show) return null;

  return (
    <div className="modal show d-block">
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">
              {initialData ? "Editar proyecto" : "Crear proyecto"}
            </h5>
            <button className="btn-close" onClick={onClose}></button>
          </div>

          <div className="modal-body">
            <ProyectoForm initialData={initialData} onSubmit={onSubmit} />
          </div>
        </div>
      </div>
    </div>
  );
}
