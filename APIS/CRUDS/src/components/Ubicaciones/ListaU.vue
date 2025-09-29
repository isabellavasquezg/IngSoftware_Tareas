<template>
  <div>
    <h2>Página Ver Ubicaciones</h2>
    <div v-for="ubicacion in ubicaciones" :key="ubicacion.id">
      <p>ID: {{ ubicacion.id }}</p>
      <p>Código: {{ ubicacion.CodigoAsignado }}</p>
      <p>Nombre: {{ ubicacion.nombre }}</p>
      <p>Ubicación: {{ ubicacion.ubicacion }}</p>
      <p>Teléfono: {{ ubicacion.telefono }}</p>
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
            this.ubicaciones = data
          } else {
            this.ubicaciones = []
          }
        })
        .catch(err => console.error('Error al cargar ubicaciones:', err))
    }
  }
}
</script>
