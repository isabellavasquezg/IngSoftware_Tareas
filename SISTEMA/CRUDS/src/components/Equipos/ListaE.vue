<template>
  <div class="inicio-page">
    <div class="container-fluid h-100">
      <div class="row h-100">
        <!-- Sidebar Izquierdo -->
        <div class="col-md-3 d-flex flex-column p-0 sidebar">
          <div class="sidebar-content flex-grow-1 d-flex flex-column justify-content-between">
            <!-- Logo + título -->
            <div class="text-center py-4">
              <div class="icono-circular mx-auto mb-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <h2 class="titulo-sidebar">Ubicaciones</h2>
            </div>
            <!-- Opciones -->
            <div class="enlaces-centrales">
              <ul class="list-unstyled px-4">
                <li class="mb-3 opcion-link">
                  <a href="#" @click.prevent="mostrarBuscador = true" class="sidebar-link">Buscar Ubicación</a>
                  <hr />
                </li>
                <li class="mb-3 opcion-link">
                  <router-link :to="{name:'insertarU'}" class="sidebar-link">Nueva Ubicación</router-link>
                  <hr />
                </li>
              </ul>
            </div>
            <!-- Botones inferiores -->
            <div class="botones-inferiores d-flex">
              <router-link to="/home" class="btn btn-icon active w-50 d-flex align-items-center justify-content-center">
                <i class="bi bi-house"></i>
              </router-link>
              <router-link to="/" class="btn btn-icon w-50 d-flex align-items-center justify-content-center">
                <i class="bi bi-power"></i>
              </router-link>
            </div>
          </div>
        </div>
        <!-- Contenido Derecho -->
        <div class="col-md-9 d-flex flex-column p-4">
          <div class="card shadow flex-grow-1">
            <div class="card-header bg-secondary text-white">
              <h3 class="mb-0">Listado de Equipos</h3>
            </div>
            <div class="card-body tabla-scroll">
              <div class="table-responsive tabla-contenedor">
                <table class="table table-bordered table-hover align-middle">
                  <thead class="table-secondary">
                    <tr>
                      <th>ID</th>
                      <th>Número Equipo</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>Ubicación</th>
                      <th>Responsable</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="equipo in equipos" :key="equipo.id">
                      <td>{{ equipo.id }}</td>
                      <td>{{ equipo.numeroActivo }}</td>
                      <td>{{ equipo.marca }}</td>
                      <td>{{ equipo.modelo }}</td>
                      <td>{{ equipo.ubicacion_completa }}</td>
                      <td>{{ equipo.responsable_completo }}</td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Grupo básico">
                          <router-link :to="{ name:'editarE', params:{ id: equipo.id } }" class="btn btn-warning btn-sm">Editar</router-link>
                          <button type="button" @click="borrarEquipo(equipo.id)" class="btn btn-danger btn-sm">Eliminar</button>
                        </div>
                      </td>
                    </tr>
                    <tr v-if="equipos.length === 0">
                      <td colspan="7" class="text-center text-muted">No hay equipos registrados</td>
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
          if (Array.isArray(data) && typeof data[0]?.success === 'undefined') {
            this.equipos = data
          } else {
            this.equipos = []
          }
        })
        .catch(err => {
          console.error('Error al cargar equipos:', err)
          this.equipos = [];
        })
    },
    borrarEquipo(id) {
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?borrar=' + id)
        .then(res => res.json())
        .then(() => {
          this.consultarEquipos()
        })
        .catch(err => console.error('Error al eliminar equipo:', err))
    }
  }
}
</script>

<style scoped>
.ubicaciones-page {
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
.icono-circular i {
  font-size: 50px;
  color: #6c858a;
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
.sidebar-link {
  color: #cfd8dc;
  font-size: 1.1rem;
  font-weight: bold;
  text-decoration: none;
  cursor: pointer;
}
.sidebar-link:hover {
  text-decoration: underline;
}
.tabla-scroll {
  height: calc(100vh - 150px);
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
.btn-warning {
  background: #ffc107 !important;
  color: #222 !important;
  border: none;
}
.btn-danger {
  background: #dc3545 !important;
  color: #fff !important;
  border: none;
}

/* Buscador Modal */
.buscador-modal {
  position: fixed;
  inset: 0;
  z-index: 2000;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
}
.buscador-form-container {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px rgba(44,62,80,0.18);
  padding: 2.5rem 2rem 2rem 2rem;
  min-width: 350px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.buscador-form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
  align-items: center;
}
.form-group {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: stretch;
}
.form-label {
  font-weight: bold;
  color: #6c858a;
  margin-bottom: 0.3rem;
  font-size: 1.1rem;
}
.form-control {
  border: none;
  border-bottom: 2px solid #6c858a;
  outline: none;
  background: transparent;
  font-size: 1.1rem;
  padding: 0.3rem 0;
  color: #2c3e50;
  transition: border-color 0.2s;
  border-radius: 0;
  box-shadow: none;
}
.form-control:focus {
  border-bottom: 2.5px solid #3e5660;
  background: transparent;
  box-shadow: none;
}
.btn-buscar {
  width: 100%;
  background: #6c858a;
  color: #fff;
  border: none;
  border-radius: 32px;
  padding: 0.9rem 0;
  font-size: 1.3rem;
  font-weight: bold;
  text-align: center;
  margin-top: 1.2rem;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  text-decoration: none;
}
.btn-buscar:hover {
  background: #4d5e65;
}
</style>
