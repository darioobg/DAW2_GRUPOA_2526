import Sidebar from "../components/Sidebar";
import Header from "../components/Header";
import { Outlet } from "react-router-dom";

function AppLayout() {
  return (
    <div className="d-flex vh-100">
      <Sidebar />

      <div className="flex-grow-1 d-flex flex-column">
        <Header />

        <main className="flex-grow-1 p-4 overflow-auto">
          <Outlet />
        </main>
      </div>
    </div>
  );
}

export default AppLayout;
