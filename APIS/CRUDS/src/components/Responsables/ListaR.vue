<template>
  <div>
    <h2>Página Ver Responsables</h2>
    <div v-for="responsables in responsableses" :key="responsables.id">
      <p>ID: {{ responsables.id }}</p>
      <p>Código: {{ responsables.CodigoAsignado }}</p>
      <p>Nombre: {{ responsables.nombre }}</p>
      <p>Ubicación: {{ responsables.responsables }}</p>
      <p>Teléfono: {{ responsables.telefono }}</p>
      <hr>
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
    this.consultarResponsables()
  },
  methods: {
    consultarResponsables() {
      fetch('http://localhost/APIS/ubicaciones/Ubicaciones.php') // 👈 apunta al archivo PHP correcto
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
    }
  }
}
</script>