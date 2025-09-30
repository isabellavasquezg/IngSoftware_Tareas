<template>
  <div class="container">
    <div class="card">
      <div class="card-header"><h3>Responsanles</h3></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-light">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Código Asignado</th>
                <th scope="col">Documento</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Cargo</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="responsable in responsables" :key="responsable.id">
                <td>{{ responsable.id }}</td>
                <td>{{ responsable.codigoAsignado }}</td>
                <td>{{ responsable.documentoIdentidad }}</td>
                <td>{{ responsable.nombre }}</td>
                <td>{{ responsable.apellido }}</td>
                <td>{{ responsable.cargo }}</td>
                <td>{{ responsable.telefono }}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Grupo básico">
                    <router-link :to="{name:'editarR', params:{id:responsable.id}}" class="btn btn-warning">Editar</router-link>
                    <button type="button" v-on:click="borrarResponsable(responsable.id)" class="btn btn-danger">Eliminar</button>
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
      responsables: []   // 👈 inicializado vacío
    }
  },
  created() {
    this.consultarResponsables()
  },
  methods: {
    consultarResponsables() {
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Responsables.php') // 👈 apunta al archivo PHP correcto
        .then(res => res.json())
        .then(data => {
          console.log(data)
          // Si la API devuelve [{"success":0}] cuando no hay registros
          if (typeof data[0]?.success === 'undefined') {
            this.responsables = data
          } else {
            this.responsables = []
          }
        })
        .catch(err => console.error('Error al cargar responsables:', err))
    },
    borrarResponsable(id) {
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Responsables.php?borrar=' + id)
        .then(res => res.json())
        .then(data => {
          console.log(data)
          window.location.href="listaR" // Refresca la lista después de eliminar
        })
        .catch(err => console.error('Error al eliminar responsable:', err))
    }
  }
}
</script>