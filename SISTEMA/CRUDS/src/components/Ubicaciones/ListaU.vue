<template>
  <div class="ubicaciones-page">
    <div class="container-fluid h-100">
      <div class="row h-100">
        
        <!-- Sidebar Izquierdo -->
        <div class="col-md-3 d-flex flex-column p-0 sidebar">
          <div class="sidebar-content flex-grow-1 d-flex flex-column justify-content-between">
            
            <!-- Logo + título -->
            <div class="text-center py-4">
              <i class="bi bi-geo-alt-fill fs-1 text-light"></i>
              <h4 class="text-light mt-2">Ubicaciones</h4>
            </div>

            <!-- Opciones -->
            <ul class="list-unstyled px-4">
              <li class="mb-3">
                <!-- ahora es un toggle que muestra el buscador -->
                <a href="#" @click.prevent="mostrarBuscador = !mostrarBuscador" class="text-light text-decoration-none">
                  🔍 Buscar Ubicación
                </a>
              </li>
              <li class="mb-3">
                <router-link :to="{name:'insertarU'}" class="text-light text-decoration-none">➕ Nueva Ubicación</router-link>
              </li>
            </ul>

            <!-- Botón inferior -->
            <div class="text-center pb-3">
              <router-link to="/" class="btn btn-light btn-sm">🏠 Inicio</router-link>
            </div>
          </div>
        </div>

        <!-- Contenido Derecho -->
        <div class="col-md-9 d-flex flex-column p-4">
          <div class="card shadow flex-grow-1">
            <div class="card-header bg-secondary text-white">
              <h3 class="mb-0">Listado de Ubicaciones</h3>
            </div>
            <div class="card-body">

              <!-- Campo de búsqueda dinámico -->
              <div v-if="mostrarBuscador" class="mb-3">
                <input type="text" v-model="filtro" class="form-control" placeholder="Buscar por código asignado...">
              </div>

              <!-- Tabla -->
              <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                  <thead class="table-secondary">
                    <tr>
                      <th>ID</th>
                      <th>Código Asignado</th>
                      <th>Nombre</th>
                      <th>Ubicación</th>
                      <th>Teléfono</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="ubicacion in ubicacionesFiltradas" :key="ubicacion.id">
                      <td>{{ ubicacion.id }}</td>
                      <td>{{ ubicacion.codigoAsignado }}</td>
                      <td>{{ ubicacion.nombre }}</td>
                      <td>{{ ubicacion.ubicacion }}</td>
                      <td>{{ ubicacion.telefono }}</td>
                      <td>
                        <div class="btn-group">
                          <router-link :to="{name:'editarU', params:{id: ubicacion.id}}" class="btn btn-warning btn-sm">Editar</router-link>
                          <button type="button" @click="borrarUbicacion(ubicacion.id)" class="btn btn-danger btn-sm">Eliminar</button>
                        </div>
                      </td>
                    </tr>
                    <tr v-if="ubicacionesFiltradas.length === 0">
                      <td colspan="6" class="text-center text-muted">No hay ubicaciones registradas</td>
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
  name: "ListaUbicaciones",
  data() {
    return {
      ubicaciones: [],
      filtro: "",
      mostrarBuscador: false
    }
  },
  created() {
    this.consultarUbicaciones()
  },
  computed: {
    ubicacionesFiltradas() {
      if (!this.filtro) return this.ubicaciones
      return this.ubicaciones.filter(u => 
        u.codigoAsignado.toLowerCase().includes(this.filtro.toLowerCase())
      )
    }
  },
  methods: {
    consultarUbicaciones() {
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php')
        .then(res => res.json())
        .then(data => {
          if (typeof data[0]?.success === 'undefined') {
            this.ubicaciones = data
          } else {
            this.ubicaciones = []
          }
        })
        .catch(err => console.error('Error al cargar ubicaciones:', err))
    },
    borrarUbicacion(id) {
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php?borrar=' + id)
        .then(res => res.json())
        .then(() => {
          this.consultarUbicaciones()
        })
        .catch(err => console.error('Error al eliminar ubicación:', err))
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
  background-color: #557c83; /* azul/verde del mockup */
  color: white;
}

.sidebar a {
  display: block;
  padding: 0.5rem 0;
  color: white;
}

.sidebar a:hover {
  text-decoration: underline;
}
</style>
