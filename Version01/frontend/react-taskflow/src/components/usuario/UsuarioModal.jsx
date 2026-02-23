import { useState } from "react";

export default function UsuarioModal({ initialData, onClose, onSubmit }) {
  const [form, setForm] = useState({
    nombre: initialData?.name ?? "",
    email: initialData?.email ?? "",
  });

  function handleChange(e) {
    setForm({ ...form, [e.target.name]: e.target.value });
  }

  function handleSubmit(e) {
    e.preventDefault();
    onSubmit(form);
  }

  return (
    <div className="modal-overlay">
      <div className="modal-box">
        <h5>{initialData ? "Editar Usuario" : "Crear Usuario"}</h5>

        <form onSubmit={handleSubmit}>
          <input
            className="form-control mb-3"
            name="nombre"
            value={form.nombre}
            onChange={handleChange}
            placeholder="Nombre"
            required
          />

          <input
            className="form-control mb-3"
            name="email"
            type="email"
            value={form.email}
            onChange={handleChange}
            placeholder="Email"
            required
          />

          <div className="text-end">
            <button
              type="button"
              className="btn btn-secondary me-2"
              onClick={onClose}
            >
              Cancelar
            </button>

            <button type="submit" className="btn btn-primary">
              {initialData ? "Actualizar" : "Crear"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
