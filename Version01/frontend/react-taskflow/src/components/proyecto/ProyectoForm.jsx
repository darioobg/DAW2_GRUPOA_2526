import React, { useEffect, useState } from "react";
import Negocio from "../../core/Negocio";

// Utilidad para formatear fecha YYYY-MM-DD desde Date/String
function formatDate(date) {
  if (!date) return "";
  return String(date).split("T")[0];
}

function getInitialFormState(initialData) {
  // Si es edición, cargamos datos del proyecto; si no, valores predeterminados
  if (initialData?.id) {
    return {
      nombre: initialData.nombre || "",
      descripcion: initialData.descripcion || "",
      fecha_inicio: formatDate(
        initialData.fechaInicio || initialData.fecha_inicio,
      ),
      fecha_fin_prevista: formatDate(
        initialData.fechaFinPrevista || initialData.fecha_fin_prevista,
      ),
      fecha_creacion: formatDate(
        initialData.fechaCreacion || initialData.fecha_creacion,
      ),
      id_equipo: String(initialData.idEquipo ?? initialData.id_equipo ?? ""),
      id_estado_proyecto: String(
        initialData.idEstadoProyecto ?? initialData.id_estado_proyecto ?? "1",
      ),
    };
  }
  // Estado inicial para crear (crear vacío)
  return {
    nombre: "",
    descripcion: "",
    fecha_inicio: "",
    fecha_fin_prevista: "",
    fecha_creacion: "",
    id_equipo: "",
    id_estado_proyecto: "1",
  };
}

function ProyectoForm({ initialData = null, onSubmit, onCancel }) {
  const isEdit = !!initialData?.id;

  const [equipos, setEquipos] = useState([]);
  const [estados, setEstados] = useState([]);
  // Eliminados error/setError/loading/setLoading ya que no se usan

  // Estado del formulario, depende si es crear o editar
  const [form, setForm] = useState(() => getInitialFormState(initialData));

  // Actualiza el form cuando cambian los datos iniciales (por ej, al cambiar de proyecto a editar)
  useEffect(() => {
    setForm(getInitialFormState(initialData));
  }, [initialData]);

  // Traer equipos y estados al montar
  useEffect(() => {
    let cancelado = false;
    (async () => {
      try {
        const [equiposData, estadosData] = await Promise.all([
          Negocio.obtenerEquipos(),
          Negocio.obtenerEstadosProyecto(),
        ]);
        if (!cancelado) {
          setEquipos(equiposData || []);
          setEstados(estadosData || []);
        }
      } catch (e) {
        if (!cancelado) {
          console.error(e);
        }
      }
    })();
    return () => {
      cancelado = true;
    };
  }, []);

  const handleChange = (e) => {
    setForm((prev) => ({ ...prev, [e.target.name]: e.target.value }));
  };

  // Construye el payload según corresponde para crear o editar
  const handleSubmit = (e) => {
    e.preventDefault();
    const nombre = form.nombre.trim();
    if (!nombre) return;

    // Al editar, enviar payload CON las claves exactas:
    //  "nombre", "descripcion", "idEquipo", "fechaCreacion", "fechaInicio", "fechaFinPrevista", "idEstadoProyecto"
    if (isEdit) {
      const payload = {
        nombre: nombre,
        descripcion: form.descripcion ?? "",
        idEquipo: form.id_equipo ? parseInt(form.id_equipo, 10) : null,
        fechaCreacion:
          form.fecha_creacion ||
          (initialData?.fechaCreacion
            ? formatDate(initialData.fechaCreacion)
            : ""),
        fechaInicio: form.fecha_inicio || "",
        fechaFinPrevista: form.fecha_fin_prevista || "",
        idEstadoProyecto: form.id_estado_proyecto
          ? parseInt(form.id_estado_proyecto, 10)
          : null,
      };
      // Eliminamos los campos nulos
      Object.keys(payload).forEach((key) => {
        if (payload[key] === null || payload[key] === undefined)
          delete payload[key];
      });
      onSubmit?.(payload);
    } else {
      // En crear, se arma el payload original (ajustado para incluir equipo)
      const payload = {
        nombre,
      };
      if (form.descripcion.trim())
        payload.descripcion = form.descripcion.trim();
      if (form.id_equipo) payload.id_equipo = parseInt(form.id_equipo, 10);
      if (form.id_estado_proyecto)
        payload.id_estado_proyecto = parseInt(form.id_estado_proyecto, 10);
      if (form.fecha_inicio) payload.fecha_inicio = form.fecha_inicio;
      if (form.fecha_fin_prevista)
        payload.fecha_fin_prevista = form.fecha_fin_prevista;
      onSubmit?.(payload);
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      {/* Nombre (obligatorio) */}
      <div className="mb-3">
        <label className="form-label">Nombre</label>
        <input
          type="text"
          className="form-control"
          name="nombre"
          value={form.nombre}
          onChange={handleChange}
          required
        />
      </div>

      {/* Descripción solo para CREAR */}
      {!isEdit && (
        <>
          <div className="mb-3">
            <label className="form-label">Descripción</label>
            <textarea
              className="form-control"
              name="descripcion"
              value={form.descripcion}
              onChange={handleChange}
            />
          </div>
          <div className="mb-3">
            <label className="form-label">Equipo</label>
            <select
              className="form-select"
              name="id_equipo"
              value={form.id_equipo}
              onChange={handleChange}
            >
              <option value="">(Sin equipo)</option>
              {equipos.map((eq) => (
                <option key={eq.id} value={eq.id}>
                  {eq.nombre}
                </option>
              ))}
            </select>
          </div>
        </>
      )}

      {/* En EDITAR, todo el resto. */}
      {isEdit && (
        <>
          <div className="mb-3">
            <label className="form-label">Descripción</label>
            <textarea
              className="form-control"
              name="descripcion"
              value={form.descripcion}
              onChange={handleChange}
            />
          </div>
          <div className="mb-3">
            <label className="form-label">Equipo</label>
            <select
              className="form-select"
              name="id_equipo"
              value={form.id_equipo}
              onChange={handleChange}
            >
              <option value="">(Sin equipo)</option>
              {equipos.map((eq) => (
                <option key={eq.id} value={eq.id}>
                  {eq.nombre}
                </option>
              ))}
            </select>
          </div>

          <div className="mb-3">
            <label className="form-label">Estado</label>
            <select
              className="form-select"
              name="id_estado_proyecto"
              value={form.id_estado_proyecto}
              onChange={handleChange}
            >
              {estados.map((est) => (
                <option key={est.id} value={est.id}>
                  {est.nombre}
                </option>
              ))}
            </select>
          </div>

          <div className="mb-3">
            <label className="form-label">Fecha creación</label>
            <input
              type="date"
              className="form-control"
              name="fecha_creacion"
              value={form.fecha_creacion}
              onChange={handleChange}
              disabled
            />
          </div>

          <div className="mb-3">
            <label className="form-label">Fecha inicio</label>
            <input
              type="date"
              className="form-control"
              name="fecha_inicio"
              value={form.fecha_inicio}
              onChange={handleChange}
            />
          </div>

          <div className="mb-3">
            <label className="form-label">Fecha fin prevista</label>
            <input
              type="date"
              className="form-control"
              name="fecha_fin_prevista"
              value={form.fecha_fin_prevista}
              onChange={handleChange}
            />
          </div>
        </>
      )}

      <div className="d-flex justify-content-end gap-2">
        <button
          type="button"
          className="btn btn-outline-secondary"
          onClick={onCancel}
        >
          Cancelar
        </button>

        <button type="submit" className="btn btn-primary">
          {isEdit ? "Guardar cambios" : "Crear"}
        </button>
      </div>
    </form>
  );
}

export default ProyectoForm;
