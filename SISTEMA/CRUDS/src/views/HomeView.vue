<template>
  <div class="inicio-page">
    <div class="container-fluid h-100">
      <div class="row h-100">
        <!-- Sidebar Izquierdo -->
        <div class="col-md-3 d-flex flex-column p-0 sidebar">
          <div class="text-center py-4">
            <div class="icono-circular mx-auto mb-3">
              <svg width="70" height="70" fill="none" viewBox="0 0 24 24">
                <path d="M3 10.5L12 4l9 6.5" stroke="#6c858a" stroke-width="2" fill="none"/>
                <rect x="6" y="11" width="12" height="8" rx="2" stroke="#6c858a" stroke-width="2" fill="none"/>
                <path d="M9 19V13h6v6" stroke="#6c858a" stroke-width="2" fill="none"/>
              </svg>
            </div>
            <h2 class="titulo-sidebar">Inicio</h2>
          </div>
          <div class="enlaces-centrales">
            <ul class="list-unstyled px-4">
              <li class="mb-3 opcion-link">
                <router-link to="/listaU"><span>Ubicaciones</span></router-link>
                <hr />
              </li>
              <li class="mb-3 opcion-link">
                <router-link to="/listaR"><span>Responsables</span></router-link>
                <hr />
              </li>
              <li class="mb-3 opcion-link">
                <router-link to="/listaE"><span>Equipos</span></router-link>
                <hr />
              </li>
            </ul>
          </div>
          <div class="botones-inferiores d-flex">
            <button class="btn btn-icon active w-50"><i class="bi bi-house"></i></button>
            <router-link to="/" class="btn btn-icon w-50 d-flex align-items-center justify-content-center">
              <i class="bi bi-power"></i>
            </router-link>
          </div>
        </div>
        <!-- Contenido Derecho -->
        <div class="col-md-9 d-flex flex-column p-4">
          <div class="card shadow flex-grow-1">
            <div class="card-body tabla-scroll">
              <div class="table-responsive tabla-contenedor">
                <table class="table table-bordered align-middle">
                  <thead style="background: #6c858a; color: #fff;">
                    <tr>
                      <th>ID</th>
                      <th>Código Asignado</th>
                      <th>Documento</th>
                      <th>Identidad</th>
                      <th>Nombre</th>
                      <th>Apellidos</th>
                      <th>Cargo</th>
                      <th>Teléfono</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="equipo in equipos" :key="equipo.id">
                      <td>{{ equipo.id }}</td>
                      <td>{{ equipo.codigoAsignado }}</td>
                      <td>{{ equipo.documento }}</td>
                      <td>{{ equipo.identidad }}</td>
                      <td>{{ equipo.nombre }}</td>
                      <td>{{ equipo.apellidos }}</td>
                      <td>{{ equipo.cargo }}</td>
                      <td>{{ equipo.telefono }}</td>
                      <td>
                        <button class="btn btn-light btn-sm rounded-circle">
                          <i class="bi bi-three-dots-vertical"></i>
                        </button>
                      </td>
                    </tr>
                    <tr v-if="equipos.length === 0">
                      <td colspan="9" class="text-center text-muted">No hay equipos registrados</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomeView",
  data() {
    return {
      equipos: []
    }
  },
  created() {
    this.consultarEquipos()
  },
  methods: {
    consultarEquipos() {
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php')
        .then(res => res.json())
        .then(data => {
          // Si tu API devuelve un objeto con una propiedad, ajusta aquí
          this.equipos = Array.isArray(data) ? data : [];
        })
        .catch(err => {
          console.error('Error al cargar equipos:', err)
          this.equipos = [];
        })
    }
  }
}
</script>

<style scoped>
.inicio-page {
  height: 100vh;
  overflow: hidden;
}
.sidebar {
  background-color: #6c858a;
  color: white;
  height: 100vh;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.icono-circular {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background-color: #cfd8dc;
  display: flex;
  align-items: center;
  justify-content: center;
}
.titulo-sidebar {
  font-size: 1.8rem;
  font-weight: bold;
  color: #cfd8dc;
}
.enlaces-centrales ul {
  padding: 0;
}
.opcion-link hr {
  border: none;
  border-top: 2px solid #cfd8dc;
  margin: 0.3rem 0;
}
.sidebar span {
  color: #cfd8dc;
  font-size: 1.1rem;
  font-weight: bold;
}
.sidebar a {
  text-decoration: none;
}
.sidebar a.router-link-exact-active span {
  text-decoration: underline;
}
.tabla-scroll {
  height: calc(100vh - 100px);
  overflow-y: auto;
  background: transparent;
}
.tabla-contenedor {
  max-height: 60vh;
  overflow-y: auto;
}
.botones-inferiores {
  padding: 0;
  background: #b7c9cc;
}
.btn-icon {
  width: 100%;
  height: 50px;
  border-radius: 0;
  background-color: #b7c9cc;
  border: none;
  font-size: 1.7rem;
  color: #6c858a;
  display: flex;
  align-items: center;
  justify-content: center;
}
.btn-icon.active {
  background-color: #6c858a;
  color: #fff;
}
</style>
