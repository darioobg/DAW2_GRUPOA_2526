import { useState, createContext, useEffect } from "react";
import Negocio from "../core/Negocio";

const SeguridadContext = createContext();

function SeguridadProvider({ children }) {
  const [datos, setDatos] = useState({
    usuario: null,
    token: null,
    equipos: [],
    equipoActivo: null,
    rolActivo: null,
    tienePermisos: false,
  });

  const [cargando, setCargando] = useState(true);

  // Restaurar sesión al montar la app
  useEffect(() => {
    try {
      const token = localStorage.getItem("token");
      const usuario = localStorage.getItem("usuario");
      const equipos = localStorage.getItem("equipos");
      const equipoActivo = localStorage.getItem("equipoActivo");

      if (token && usuario && equipos) {
        const equiposParsed = JSON.parse(equipos);
        const equipoActivoParsed = equipoActivo
          ? JSON.parse(equipoActivo)
          : equiposParsed[0];

        setDatos({
          usuario: JSON.parse(usuario),
          token,
          equipos: equiposParsed,
          equipoActivo: equipoActivoParsed,
          rolActivo: equipoActivoParsed?.rol ?? null,
          tienePermisos: true,
        });
      }
    } catch (error) {
      console.error("Error restaurando sesión:", error);
      localStorage.clear();
    } finally {
      setCargando(false);
    }
  }, []);

  // LOGIN
  const logIn = async (email, password) => {
    const data = await Negocio.logIn(email, password);

    const equipoInicial = data.equipos?.[0] ?? null;

    localStorage.setItem("token", data.access_token);
    localStorage.setItem("usuario", JSON.stringify(data.user));
    localStorage.setItem("equipos", JSON.stringify(data.equipos));
    localStorage.setItem("equipoActivo", JSON.stringify(equipoInicial));

    setDatos({
      usuario: data.user,
      token: data.access_token,
      equipos: data.equipos,
      equipoActivo: equipoInicial,
      rolActivo: equipoInicial?.rol ?? null,
      tienePermisos: true,
    });
  };

  // Cambiar equipo activo
  const cambiarEquipo = (equipo) => {
    localStorage.setItem("equipoActivo", JSON.stringify(equipo));

    setDatos((prev) => ({
      ...prev,
      equipoActivo: equipo,
      rolActivo: equipo?.rol ?? null,
    }));
  };

  // LOGOUT
  const logOut = async () => {
    try {
      await Negocio.logOut();
    } catch (e) {
      console.warn("Token posiblemente expirado");
    }

    localStorage.clear();

    setDatos({
      usuario: null,
      token: null,
      equipos: [],
      equipoActivo: null,
      rolActivo: null,
      tienePermisos: false,
    });
  };

  return (
    <SeguridadContext.Provider
      value={{
        datos,
        cargando,
        logIn,
        logOut,
        cambiarEquipo,
      }}
    >
      {children}
    </SeguridadContext.Provider>
  );
}

export { SeguridadContext, SeguridadProvider };
