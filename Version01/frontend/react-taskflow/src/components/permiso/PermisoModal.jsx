import { useEffect, useState } from "react";

export default function PermisoModal({
  initialData,
  usuarios,
  equipos,
  roles,
  onClose,
  onSubmit,
}) {
  const editando = !!initialData;

  const [form, setForm] = useState({
    idUsuario: "",
    idEquipo: "",
    idRol: "",
    fechaAlta: "",
  });

  useEffect(() => {
    if (initialData) {
      setForm({
        idUsuario: initialData.idUsuario ?? "",
        idEquipo: initialData.idEquipo ?? "",
        idRol: initialData.idRol ?? "",
        fechaAlta: initialData.fechaAlta ?? "",
      });
    } else {
      setForm({
        idUsuario: "",
        idEquipo: "",
        idRol: "",
        fechaAlta: new Date().toISOString().slice(0, 10), // default hoy
      });
    }
  }, [initialData]);

  function handleChange(e) {
    setForm((prev) => ({ ...prev, [e.target.name]: e.target.value }));
  }

  function handleSubmit(e) {
    e.preventDefault();

    // Normaliza a números donde aplique (si tu backend espera ints)
    const payload = {
      idUsuario: Number(form.idUsuario),
      idEquipo: Number(form.idEquipo),
      idRol: Number(form.idRol),
      fechaAlta: form.fechaAlta,
    };

    onSubmit(payload);
  }

  return (
    <div className="admin-modal-overlay">
      <div className="admin-modal">
        <h2 className="mb-3">
          {editando ? "Editar Permiso" : "Asignar Permiso"}
        </h2>

        <form onSubmit={handleSubmit}>
          <div className="mb-3">
            <label className="form-label">Usuario</label>
            <select
              className="form-select"
              name="idUsuario"
              value={form.idUsuario}
              onChange={handleChange}
              required
              disabled={editando}
            >
              <option value="">-- Seleccionar --</option>
              {usuarios.map((u) => (
                <option key={u.id} value={u.id}>
                  {u.nombre} ({u.email})
                </option>
              ))}
            </select>
            {editando && (
              <small className="text-muted">
                * En edición no se cambia el usuario (clave del registro).
              </small>
            )}
          </div>

          <div className="mb-3">
            <label className="form-label">Equipo</label>
            <select
              className="form-select"
              name="idEquipo"
              value={form.idEquipo}
              onChange={handleChange}
              required
              disabled={editando}
            >
              <option value="">-- Seleccionar --</option>
              {equipos.map((eq) => (
                <option key={eq.id} value={eq.id}>
                  {eq.nombre}
                </option>
              ))}
            </select>
            {editando && (
              <small className="text-muted">
                * En edición no se cambia el equipo (clave del registro).
              </small>
            )}
          </div>

          <div className="mb-3">
            <label className="form-label">Rol</label>
            <select
              className="form-select"
              name="idRol"
              value={form.idRol}
              onChange={handleChange}
              required
            >
              <option value="">-- Seleccionar --</option>
              {roles.map((r) => (
                <option key={r.id} value={r.id}>
                  {r.nombre}
                </option>
              ))}
            </select>
          </div>

          <div className="mb-3">
            <label className="form-label">Fecha Alta</label>
            <input
              className="form-control"
              type="date"
              name="fechaAlta"
              value={form.fechaAlta}
              onChange={handleChange}
              required
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
              {editando ? "Guardar cambios" : "Asignar"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
