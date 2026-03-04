import React, { useState, useContext } from "react";
import { SeguridadContext } from "../../contexts/SeguridadProvider";
import { useNavigate } from "react-router-dom";

function LoginPage() {
  const { logIn } = useContext(SeguridadContext);
  const navigate = useNavigate();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      await logIn(email, password);
      navigate("/");
    } catch (err) {
      setError("Credenciales incorrectas");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="container-fluid login-container">
      <div className="row w-100">
        {/* Panel Izquierdo */}
        <div className="col-md-6 left-panel d-none d-md-flex">
          <div>
            <h2 className="fw-bold mb-4">TaskFlow</h2>
            <h3 className="fw-semibold mb-3">
              TaskFlow ayuda a los equipos a avanzar en el trabajo.
            </h3>
            <p>Gestiona proyectos y tareas de forma organizada y visual.</p>
          </div>
        </div>

        {/* Panel Derecho */}
        <div className="col-md-6 form-panel">
          <div className="login-card">
            <h4 className="text-center mb-4">Bienvenido a TaskFlow</h4>

            {error && <div className="alert alert-danger">{error}</div>}

            <form onSubmit={handleSubmit}>
              <div className="mb-3">
                <label className="form-label">Correo electrónico</label>
                <input
                  type="email"
                  className="form-control"
                  placeholder="Introduce tu correo"
                  value={email}
                  required
                  onChange={(e) => setEmail(e.target.value)}
                  autoComplete="username"
                />
              </div>

              <div className="mb-3">
                <label className="form-label">Contraseña</label>
                <input
                  type="password"
                  className="form-control"
                  placeholder="Introduce tu contraseña"
                  value={password}
                  required
                  onChange={(e) => setPassword(e.target.value)}
                  autoComplete="current-password"
                />
              </div>

              <div className="d-grid">
                <button
                  type="submit"
                  className="btn btn-primary"
                  disabled={loading}
                >
                  {loading ? (
                    <>
                      <span className="spinner-border spinner-border-sm me-2"></span>
                      Entrando...
                    </>
                  ) : (
                    "Iniciar sesión"
                  )}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}

export default LoginPage;
