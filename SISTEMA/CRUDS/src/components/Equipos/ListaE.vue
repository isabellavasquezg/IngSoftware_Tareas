<template>
  <div class="container">
    <div class="card">
      <div class="card-header"><h3>Equipos</h3></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-light">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Número Equipo</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Código Ubicación</th>
                <th scope="col">Código Responsable</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="equipo in equipos" :key="equipo.id">
                <td>{{ equipo.id }}</td>
                <td>{{ equipo.numeroActivo }}</td>
                <td>{{ equipo.marca }}</td>
                <td>{{ equipo.modelo }}</td>
                <td>{{ equipo.codigoUbicacion }}</td>
                <td>{{ equipo.codigoResponsable }}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Grupo básico">
                    <router-link :to="{ name:'editarE', params:{ id: equipo.id } }" class="btn btn-warning">Editar</router-link>
                    <button type="button" @click="borrarEquipo(equipo.id)" class="btn btn-danger">Eliminar </button>
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
      equipos: []   // 👈 lista de equipos
    }
  },
  created() {
    this.consultarEquipos()
  },
  methods: {
    consultarEquipos() {
      fetch('http://localhost/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php')
        .then(res => res.json())
        .then(data => {
          console.log(data)
          if (Array.isArray(data) && typeof data[0]?.success === 'undefined') {
            this.equipos = data
          } else {
            this.equipos = []
          }
        })
        .catch(err => console.error('Error al cargar equipos:', err))
    },
    borrarEquipo(id) {
      fetch('http://localhost/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?borrar=' + id)
        .then(res => res.json())
        .then(data => {
          console.log(data)
          window.location.href='ListaE' // 👈 refresca la lista sin recargar
        })
        .catch(err => console.error('Error al eliminar equipo:', err))
    }
  }
}
</script>


