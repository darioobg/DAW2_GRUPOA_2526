import ProyectoForm from "./ProyectoForm";

export default function ProyectoModal({
  show,
  onClose,
  onSubmit,
  initialData,
}) {
  console.log("ProyectoModal montado con props:", {
    show,
    initialData,
    onClose,
    onSubmit,
  });

  if (!show) return null;

  return (
    <div
      className="modal show d-block"
      style={{ background: "rgba(0,0,0,0.5)" }}
    >
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">
              {initialData ? "Editar proyecto" : "Crear proyecto"}
            </h5>
            <button type="button" className="btn-close" onClick={onClose} />
          </div>

          <div className="modal-body">
            <ProyectoForm
              initialData={initialData}
              onSubmit={onSubmit}
              onCancel={onClose}
            />
          </div>
        </div>
      </div>
    </div>
  );
}
