import { useNavigate, Link } from "react-router-dom";

function ProyectoLinea({ proyecto }) {
  const { id = 0, nombre = "", descripcion = "" } = proyecto;

  const navegar = useNavigate();

  const handleClick = () => {
    navegar(`/proyectos/${id}`);
  };

  const handleClickNoParametro = () => {
    navegar(`/proyectosstate`, { state: { id: id } });
  };

  return (
    <p>
      <strong>{nombre}</strong> - {descripcion}
      <br />
      <button onClick={handleClick}>Navegar con id</button>
      <Link to={`/proyectos/${id}`}>Link con Id</Link>
      <br />
      <button onClick={handleClickNoParametro}>Navegar con State</button>
      <Link to="/proyectosstate" state={{ id: id }}>
        Link con State
      </Link>
    </p>
  );
}

export default ProyectoLinea;
