import { BrowserRouter, Routes, Route } from "react-router-dom";
import Login from "../pages/Login";
import Tableros from "../pages/Tableros";
import ProyectosPage from "../pages/ProyectosPage";
import TablerosDetallePage from "../pages/TableroDetallePage";
import MainLayout from "../layout/MainLayout";

export default function AppRouter() {
  return (
    <BrowserRouter>
      <Routes>
        {/* Ruta pública */}
        <Route path="/login" element={<Login />} />

        {/* Rutas con layout */}
        <Route
          path="/"
          element={
            <MainLayout>
              <ProyectosPage />
            </MainLayout>
          }
        />

        <Route
          path="/tableros"
          element={
            <MainLayout>
              <Tableros />
            </MainLayout>
          }
        />
        <Route
          path="/tableros/:idTablero"
          element={
            <MainLayout>
              <TablerosDetallePage />
            </MainLayout>
          }
        />
      </Routes>
    </BrowserRouter>
  );
}
