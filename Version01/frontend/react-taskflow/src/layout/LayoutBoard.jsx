import Header from "../components/layout/Header";
import { Outlet } from "react-router-dom";

function LayoutBoard() {
  return (
    <div className="layout-board">
      <Header />

      <main className="layout-board__main">
        <div className="layout-board__content">
          <Outlet />
        </div>
      </main>
    </div>
  );
}

export default LayoutBoard;
