<template>
  <div class="container">
    <div class="card">
      <div class="card-header"><h3>Ubicaciones</h3></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-light">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Código Asignado</th>
                <th scope="col">Nombre</th>
                <th scope="col">Ubicación</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="ubicacion in ubicaciones" :key="ubicacion.id">
                <td>{{ ubicacion.id }}</td>
                <td>{{ ubicacion.codigoAsignado }}</td>
                <td>{{ ubicacion.nombre }}</td>
                <td>{{ ubicacion.ubicacion }}</td>
                <td>{{ ubicacion.telefono }}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Grupo básico">
                    <router-link :to="{name:'editarU', params:{id: ubicacion.id}}" class="btn btn-warning">Editar</router-link>
                    <button type="button" @click="borrarUbicacion(ubicacion.id)" class="btn btn-danger">Eliminar </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      ubicaciones: []   // 👈 inicializado vacío
    }
  },
  created() {
    this.consultarUbicaciones()
  },
  methods: {
    consultarUbicaciones() {
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php') // 👈 apunta al archivo PHP correcto
        .then(res => res.json())
        .then(data => {
          console.log(data)
          // Si la API devuelve [{"success":0}] cuando no hay registros
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
      .then(data => {
        console.log(data)
        window.location.href="listaU" // Refresca la lista después de eliminar
      })
      .catch(err => console.error('Error al eliminar responsable:', err))
    }
  }
}
</script>
