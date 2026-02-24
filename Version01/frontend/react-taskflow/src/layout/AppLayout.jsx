import Sidebar from "../components/layout/Sidebar";
import Header from "../components/layout/Header";
import { Outlet } from "react-router-dom";

function AppLayout() {
  return (
    <div className="d-flex flex-column vh-100">
      <Header />

      <div className="d-flex flex-grow-1" style={{ minHeight: 0 }}>
        <Sidebar />

        <main
          className="flex-grow-1 p-4 bg-light"
          style={{ overflowY: "auto" }}
        >
          <Outlet />
        </main>
      </div>
    </div>
  );
}

export default AppLayout;
