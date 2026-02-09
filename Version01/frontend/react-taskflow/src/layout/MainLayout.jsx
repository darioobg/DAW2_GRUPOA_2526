import Sidebar from "../components/Sidebar";
import Header from "../components/Header";

export default function MainLayout({ children }) {
  return (
    <div className="d-flex app-layout">
      <Sidebar />
      <div className="flex-grow-1">
        <Header />
        <main className="main-content p-4">{children}</main>
      </div>
    </div>
  );
}
