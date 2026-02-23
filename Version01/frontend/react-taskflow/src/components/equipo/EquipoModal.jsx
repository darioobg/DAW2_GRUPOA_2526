import { useState, useEffect } from "react";

export default function EquipoModal({ initialData, onClose, onSubmit }) {
  const [formData, setFormData] = useState({
    nombre: "",
    descripcion: "",
  });

  useEffect(() => {
    if (initialData) {
      setFormData({
        nombre: initialData.nombre ?? "",
        descripcion: initialData.descripcion ?? "",
      });
    }
  }, [initialData]);

  function handleChange(e) {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  }

  function handleSubmit(e) {
    e.preventDefault();
    onSubmit(formData);
  }

  return (
    <div className="admin-modal-overlay">
      <div className="admin-modal">
        <h2>{initialData ? "Editar Equipo" : "Crear Equipo"}</h2>

        <form onSubmit={handleSubmit}>
          <div className="mb-3">
            <label>Nombre</label>
            <input
              type="text"
              name="nombre"
              className="form-control"
              value={formData.nombre}
              onChange={handleChange}
              required
            />
          </div>

          <div className="mb-3">
            <label>Descripción</label>
            <input
              type="text"
              name="descripcion"
              className="form-control"
              value={formData.descripcion}
              onChange={handleChange}
            />
          </div>

          <div className="text-end">
            <button
              type="button"
              className="btn btn-secondary me-2"
              onClick={onClose}
            >
              Cancelar
            </button>

            <button type="submit" className="btn btn-primary">
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
