import Sidebar from "../components/layout/Sidebar";
import Header from "../components/layout/Header";
import { Outlet } from "react-router-dom";

function AppLayout() {
  return (
    <div className="d-flex flex-column vh-100">
      {/* HEADER ARRIBA */}
      <Header />

      {/* DEBAJO: SIDEBAR + CONTENIDO */}
      <div className="d-flex flex-grow-1" style={{ minHeight: 0 }}>
        {/* SIDEBAR IZQUIERDA */}
        <Sidebar />

        {/* CONTENIDO DERECHA */}
        <main className="flex-grow-1 p-4 bg-light cont">
          <div style={{ flex: 1, minHeight: 0 }}>
            <Outlet />
          </div>
        </main>
      </div>
    </div>
  );
}

export default AppLayout;
