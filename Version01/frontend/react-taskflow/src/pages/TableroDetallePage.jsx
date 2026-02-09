import { useParams } from "react-router-dom";
import { useState, useEffect } from "react";
import ColumnaKanban from "../components/kanban/ColumnaKanban"; // Importa ColumnaKanban
import { obtenerTareasPorTablero } from "../services/tareasApi";

// Página de detalle de un tablero para mostrar tareas en columnas estilo Kanban con Bootstrap
export default function TableroDetallePage() {
  const { idTablero } = useParams();

  const [tareas, setTareas] = useState([]);
  const [tareaArrastradaId, setTareaArrastradaId] = useState(null);
  const [cargando, setCargando] = useState(true);
  const [error, setError] = useState(null);

  const columnas = [
    { key: 1, nombre: "Por hacer" },
    { key: 2, nombre: "En progreso" },
    { key: 3, nombre: "En revision" },
    { key: 4, nombre: "Hecho" },
  ];

  // --- DEBUGGING - no se modifican los siguientes logs, pueden eliminarse después ---
  const tareasPorEstado = tareas.filter(
    (t) => Number(t.idEstado) === Number(columnas[0].key),
  );
  console.log("TAREAS COMPLETAS:", tareas);

  tareas.forEach((t) => {
    console.log(
      "Tarea",
      t.id,
      "idEstado:",
      t.idEstado,
      "tipo:",
      typeof t.idEstado,
    );
  });
  console.log("COLUMNAS:", columnas);

  console.log("Tareas estado 1:", tareasPorEstado);
  // --- END DEBUGGING ---

  useEffect(() => {
    async function fetchTareas() {
      setCargando(true);
      setError(null);
      try {
        const datos = await obtenerTareasPorTablero(idTablero);
        setTareas(datos);
      } catch {
        setError("Error al cargar las tareas. Intenta de nuevo.");
      }
      setCargando(false);
    }
    fetchTareas();
  }, [idTablero]);

  // Utilitario: tareas ordenadas por columna por ordenKanban
  function getTareasOrdenadasPorColumna(keyColumna) {
    return tareas
      .filter((t) => Number(t.idEstado) === Number(keyColumna))
      .slice()
      .sort((a, b) => {
        if (a.ordenKanban === undefined) return 1;
        if (b.ordenKanban === undefined) return -1;
        return Number(a.ordenKanban) - Number(b.ordenKanban);
      });
  }

  // HTML5 Drag & Drop
  // Usamos el id de la tarea en dataTransfer.
  // Drag events sólo se configuran aquí mediante envoltorios.

  // Almacena el id de la tarea arrastrada (en memoria durante evento de drag)
  // (no se necesita en un estado global; HTML5 D&D lo pasa en dataTransfer)

  // Maneja el comienzo del drag; guarda el id de la tarea en el dataTransfer
  function handleDragStart(e, tareaId) {
    console.log("PADRE recibe drag:", tareaId);
    setTareaArrastradaId(tareaId);
  }

  // Permite que una columna sea "droppable"
  function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = "move";
  }

  // Cuando una tarea se suelta en una columna
  function handleDrop(e, keyColumnaDestino) {
    e.preventDefault();

    console.log("DROP en columna:", keyColumnaDestino);
    console.log("Tarea soltada:", tareaArrastradaId);

    if (!tareaArrastradaId) return;

    setTareas((tareasPrevias) => {
      // Encuentra la tarea arrastrada
      const idxTarea = tareasPrevias.findIndex(
        (t) => String(t.id) === String(tareaArrastradaId),
      );
      if (idxTarea === -1) return tareasPrevias;

      const tareaArrastrada = tareasPrevias[idxTarea];

      const idEstadoOrigen = Number(tareaArrastrada.idEstado);
      const idEstadoDestino = Number(keyColumnaDestino);

      // Si la tarea ya está en esa columna, la tratamos como reordenar (se coloca al final si vuelve a soltar)
      // NOTA: Para simplificar, soltamos siempre al final
      // Primero, obtenemos tareas destino, sin la arrastrada
      let tareasDestino = tareasPrevias.filter(
        (t) =>
          Number(t.idEstado) === idEstadoDestino &&
          String(t.id) !== String(tareaArrastradaId),
      );
      // El nuevo orden será: ...tareasDestino..., tareaArrastrada
      let nuevoOrden = tareasDestino.length + 1;

      // Creamos una copia profunda de las tareas
      const nuevasTareas = tareasPrevias.map((t) => ({ ...t }));

      // Actualizamos la tarea arrastrada
      nuevasTareas[idxTarea] = {
        ...tareaArrastrada,
        idEstado: idEstadoDestino,
        ordenKanban: nuevoOrden,
      };

      // Reasignar ordenKanban secuencial para esa columna
      // (todas las tareas de la columna destino, incluyendo la arrastrada, reindexadas)
      let actualizadas = nuevasTareas.map((t) => {
        if (Number(t.idEstado) !== idEstadoDestino) return t;
        return { ...t };
      });

      // Obtenemos todas las tareas en la columna destino, ordenadas por ordenKanban, sin la arrastrada
      let tareasDestinoReorder = actualizadas
        .filter(
          (t) =>
            Number(t.idEstado) === idEstadoDestino &&
            String(t.id) !== String(tareaArrastradaId),
        )
        .slice()
        .sort((a, b) => {
          if (a.ordenKanban === undefined) return 1;
          if (b.ordenKanban === undefined) return -1;
          return Number(a.ordenKanban) - Number(b.ordenKanban);
        });

      // Reconstruimos el array de tareas destino (ahora con la tarea arrastrada al final)
      const tareasDestinoFinal = [
        ...tareasDestinoReorder,
        { ...nuevasTareas[idxTarea] },
      ];

      // Aplicamos ordenKanban secuencial en destino
      tareasDestinoFinal.forEach((t, idx) => {
        const idxEnNuevasTareas = nuevasTareas.findIndex(
          (x) => String(x.id) === String(tareaArrastradaId),
        );
        if (idxEnNuevasTareas !== -1) {
          nuevasTareas[idxEnNuevasTareas] = {
            ...nuevasTareas[idxEnNuevasTareas],
            ordenKanban: idx + 1,
          };
        }
      });

      // Ahora, si la tarea cambio de columna, necesitamos reordenar la columna origen
      if (idEstadoDestino !== idEstadoOrigen) {
        // Obtenemos tareas restantes en origen, ordenadas
        let tareasOrigen = nuevasTareas
          .filter((t) => Number(t.idEstado) === idEstadoOrigen)
          .slice()
          .sort((a, b) => {
            if (a.ordenKanban === undefined) return 1;
            if (b.ordenKanban === undefined) return -1;
            return Number(a.ordenKanban) - Number(b.ordenKanban);
          });
        // Reasignar ordenKanban en origen
        tareasOrigen.forEach((t, idx) => {
          const idxEnNuevasTareas = nuevasTareas.findIndex(
            (x) => String(x.id) === String(t.id),
          );
          if (idxEnNuevasTareas !== -1) {
            nuevasTareas[idxEnNuevasTareas] = {
              ...nuevasTareas[idxEnNuevasTareas],
              ordenKanban: idx + 1,
            };
          }
        });
      }

      return nuevasTareas;
    });
    setTareaArrastradaId(null);
  }

  // Render principal
  return (
    <div className="container py-4">
      {/* Título principal con el id del tablero */}
      <div className="mb-4">
        <h1 className="fw-bold">
          Tablero: <span className="text-primary">{idTablero}</span>
        </h1>
      </div>
      {cargando ? (
        <div className="alert alert-info text-center" role="alert">
          Cargando tareas...
        </div>
      ) : error ? (
        <div className="alert alert-danger text-center" role="alert">
          {error}
        </div>
      ) : (
        <div className="row g-4">
          {/* Para cada columna, renderiza una zona droppable para drag&drop */}
          {columnas.map((columna) => (
            <div
              key={columna.key}
              className="col-12 col-md-4"
              // Hacemos esta columna un drop target
              onDragOver={handleDragOver}
              onDrop={(e) => handleDrop(e, columna.key)}
              style={{ minHeight: "100px" }} // visualmente más fácil para el drop
            >
              {/* Envoltorio Kanban, envía tareas de columna */}
              {/* Renderizamos las tareas como draggable */}
              <div>
                <ColumnaKanban
                  estado={columna.nombre}
                  tareas={getTareasOrdenadasPorColumna(columna.key)}
                  onDragStart={handleDragStart}
                  onDropColumna={(e) => handleDrop(e, columna.key)}
                />
                {/* Overlay invisible para interceptar y renderear las tarjetas como draggable */}
                <ul
                  className="list-unstyled kanban-drag-overlay"
                  style={{
                    position: "relative",
                    top: "-100%",
                    left: 0,
                    width: "100%",
                    pointerEvents: "none",
                  }}
                  aria-hidden="true"
                >
                  {/* 
                    Renderizamos la superposición de items (draggable)
                    Cada div overlay es draggable y absolutamente posicionado por la lista
                    Esto SOLO habilita arrastrar las tareas, la UI visible sigue igual
                  */}
                  {getTareasOrdenadasPorColumna(columna.key).map(
                    (tarea, idx) => (
                      <li
                        key={"dragov-" + tarea.id}
                        style={{
                          position: "absolute",
                          left: 0,
                          right: 0,
                          top: `${idx * 68}px`, // mismo alto que las tarjetas (aproximado)
                          height: "56px",
                          zIndex: 200,
                          pointerEvents: "auto",
                          cursor: "grab",
                          opacity: 0,
                        }}
                        draggable
                        onDragStart={(e) => handleDragStart(e, tarea.id)}
                      >
                        {/* Nada que mostrar, solo purpose para drag and drop */}
                      </li>
                    ),
                  )}
                </ul>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}
