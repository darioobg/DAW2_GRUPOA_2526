import { useState } from "react";

export default function TareaForm({ idProyecto, idEstado, onSubmit }) {
  const [titulo, setTitulo] = useState("");
  const [descripcion, setDescripcion] = useState("");

  function handleSubmit(e) {
    e.preventDefault();

    if (!titulo.trim()) return;

    onSubmit({
      titulo: titulo.trim(),
      descripcion: descripcion.trim(),
      idProyecto,
      idEstado,
    });

    // limpiar formulario
    setTitulo("");
    setDescripcion("");
  }

  return (
    <form onSubmit={handleSubmit}>
      <div className="mb-3">
        <label className="form-label">Título</label>
        <input
          type="text"
          className="form-control"
          value={titulo}
          onChange={(e) => setTitulo(e.target.value)}
          required
        />
      </div>

      <div className="mb-3">
        <label className="form-label">Descripción</label>
        <textarea
          className="form-control"
          value={descripcion}
          onChange={(e) => setDescripcion(e.target.value)}
        />
      </div>

      <button type="submit" className="btn btn-primary w-100">
        Crear Tarea
      </button>
    </form>
  );
}
