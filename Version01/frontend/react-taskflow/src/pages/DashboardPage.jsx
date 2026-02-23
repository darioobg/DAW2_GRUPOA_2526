import { useContext } from "react";
import { SeguridadContext } from "../contexts/SeguridadProvider";

import DashboardHomePage from "../pages/dashboard/DashboardHomePage";
import AdminDashboardPage from "../pages/admin/AdminDashboardPage";

export default function DashboardPage() {
  const { datos } = useContext(SeguridadContext);

  if (!datos?.usuario) return null;

  return datos.rolActivo === "ADMIN" ? (
    <AdminDashboardPage />
  ) : (
    <DashboardHomePage />
  );
}
