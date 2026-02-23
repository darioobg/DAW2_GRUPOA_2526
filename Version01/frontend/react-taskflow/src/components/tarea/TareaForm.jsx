import { useState } from "react";

export default function TareaForm({ idProyecto, idEstado, onSubmit }) {
  const [titulo, setTitulo] = useState("");

  function handleSubmit(e) {
    e.preventDefault();

    if (!titulo.trim()) return;

    const hoy = new Date().toISOString().split("T")[0];

    onSubmit({
      titulo: titulo.trim(),
      descripcion: "",
      id_proyecto: idProyecto,
      id_estado: idEstado,
      id_prioridad: 1, // baja por defecto
      id_asignado_a: 1, // usuario actual (temporal)
      fecha_creacion: hoy,
      fecha_limite: hoy,
      orden_kanban: 1,
    });

    setTitulo(""); // limpiar input
  }

  return (
    <form onSubmit={handleSubmit}>
      <div className="mb-3">
        <label>Título</label>
        <input
          className="form-control"
          value={titulo}
          onChange={(e) => setTitulo(e.target.value)}
        />
      </div>

      <button className="btn btn-primary w-100">Crear tarea</button>
    </form>
  );
}
