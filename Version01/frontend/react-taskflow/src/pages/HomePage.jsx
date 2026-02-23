import { useContext, useState } from "react";
import { SeguridadContext } from "../contexts/SeguridadProvider";

function HomePage() {
  const { datos, logIn, logOut } = useContext(SeguridadContext);
  const [nombre, setNombre] = useState("");

  function handleClick() {
    if (datos.tienePermisos) {
      setNombre("");
      logOut();
    } else {
      if (nombre === "") return;
      logIn(nombre);
    }
  }

  return (
    <>
      <h1>Página de inicio</h1>

      {datos.tienePermisos ? (
        <>
          <span>Hola {datos.usuario} </span>
          <button onClick={handleClick}>Salir</button>
        </>
      ) : (
        <>
          <input
            type="text"
            value={nombre}
            onChange={(e) => setNombre(e.target.value)}
          />
          <button onClick={handleClick}>Entrar</button>
        </>
      )}
    </>
  );
}

export default HomePage;
