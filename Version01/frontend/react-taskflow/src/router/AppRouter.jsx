import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";

import Login from "../pages/auth/LoginPage";
import DashboardPage from "../pages/DashboardPage";
import Tableros from "../pages/dashboard/TablerosPage";
import AdminDashboardPage from "../pages/admin/AdminDashboardPage";
import TableroDetallePage from "../pages/TableroDetallePage";
import DashboardHomePage from "../pages/dashboard/DashboardHomePage";
import UsuariosPage from "../pages/admin/UsuariosPage";
import EquiposPage from "../pages/admin/EquiposPage";
import RolesPage from "../pages/admin/RolesPage";
import AppLayout from "../layout/AppLayout";
import LayoutBoard from "../layout/LayoutBoard";

import RutaPrivada from "../components/navigation/RutaPrivada";
import RutaPorRol from "../components/navigation/RutaPorRol";
import PermisosPage from "../pages/admin/PermisosPage";
import MisTareasPage from "../pages/dashboard/MisTareasPage";
import MisEquiposPage from "../pages/dashboard/MisEquiposPage";
export default function AppRouter() {
  return (
    <BrowserRouter>
      <Routes>
        {/* Público */}
        <Route path="/login" element={<Login />} />

        {/* Zona protegida */}
        <Route
          path="/dashboard"
          element={
            <RutaPrivada>
              <AppLayout />
            </RutaPrivada>
          }
        >
          {/* /dashboard */}
          <Route index element={<DashboardPage />} />

          {/* /dashboard/tableros */}
          <Route path="tableros" element={<Tableros />} />
          <Route path="mis-tareas" element={<MisTareasPage />} />
          <Route path="mis-equipos" element={<MisEquiposPage />} />
          {/* /dashboard/operativo */}
          <Route
            path="operativo"
            element={
              <RutaPorRol rolesPermitidos={["ADMIN"]}>
                <DashboardHomePage />
              </RutaPorRol>
            }
          />

          {/* /dashboard/admin */}
          <Route
            path="admin"
            element={
              <RutaPorRol rolesPermitidos={["ADMIN"]}>
                <AdminDashboardPage />
              </RutaPorRol>
            }
          />

          {/* /dashboard/admin/usuarios */}
          <Route
            path="admin/usuarios"
            element={
              <RutaPorRol rolesPermitidos={["ADMIN"]}>
                <UsuariosPage />
              </RutaPorRol>
            }
          />
          <Route
            path="admin/equipos"
            element={
              <RutaPorRol rolesPermitidos={["ADMIN"]}>
                <EquiposPage />
              </RutaPorRol>
            }
          />

          <Route
            path="admin/roles"
            element={
              <RutaPorRol rolesPermitidos={["ADMIN"]}>
                <RolesPage />
              </RutaPorRol>
            }
          />
          <Route
            path="admin/permisos"
            element={
              <RutaPorRol rolesPermitidos={["ADMIN"]}>
                <PermisosPage />
              </RutaPorRol>
            }
          />
        </Route>

        {/* Board independiente */}
        <Route
          path="/tableros/:idTablero"
          element={
            <RutaPrivada>
              <LayoutBoard />
            </RutaPrivada>
          }
        >
          <Route index element={<TableroDetallePage />} />
        </Route>

        {/* Redirección final */}
        <Route path="*" element={<Navigate to="/dashboard" replace />} />
      </Routes>
    </BrowserRouter>
  );
}
