import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./styles/main.css";
import { SeguridadProvider } from "./contexts/SeguridadProvider.jsx";
// import App from './App.jsx'
import AppEnrutador from "./router/AppRouter";
createRoot(document.getElementById("root")).render(
  <StrictMode>
    {/*     
<App /> */}
    <SeguridadProvider>
      <AppEnrutador />
    </SeguridadProvider>
  </StrictMode>,
);
