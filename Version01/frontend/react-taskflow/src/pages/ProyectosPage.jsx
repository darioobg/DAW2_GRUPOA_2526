import { useEffect, useState } from "react";
import Negocio from "../core/Negocio";
import ProyectoLinea from "../components/ProyectoLinea";

function ProyectosPage() {
  const [proyectos, setProyectos] = useState([]);

  useEffect(() => {
    getProyectos();
  }, []);

  const getProyectos = async () => {
    try {
      const respuesta = await Negocio.obtenerProyectos();
      setProyectos(respuesta);
    } catch (e) {
      console.log(e);
    }
  };

  return (
    <>
      <h1>Lista de Proyectos</h1>

      {proyectos.map((cadaProyecto) => {
        return <ProyectoLinea key={cadaProyecto.id} proyecto={cadaProyecto} />;
      })}
    </>
  );
}

export default ProyectosPage;
