import { BrowserRouter, Routes, Route } from "react-router-dom";
import Login from "../pages/Login";
import Tableros from "../pages/Tableros";
import DashboardPage from "../pages/DashboardPage";
import TablerosDetallePage from "../pages/TableroDetallePage";
import AppLayout from "../layout/AppLayout";
import TableroDetallePage from "../pages/TableroDetallePage";

export default function AppRouter() {
  return (
    <BrowserRouter>
      <Routes>
        {/* Ruta pública */}
        <Route path="/login" element={<Login />} />
        {/* Rutas protegidas con layout */}
        <Route path="/" element={<AppLayout />}>
          <Route index element={<DashboardPage />} />

          <Route path="tableros" element={<Tableros />} />
          <Route path="tableros/:idTablero" element={<TablerosDetallePage />} />
          <Route path="tablerosstate" element={<TableroDetallePage />} />

          {/* Ruta catch-all opcional, para no encontradas */}
          {/* <Route path="*" element={<NoPage />} /> */}
        </Route>
      </Routes>
    </BrowserRouter>
  );
}
