<template>
  <div class="container">
    <form v-on:submit.prevent="actualizarEquipo">
      <div class="mb-3">
        <label for="numeroActivo" class="form-label">Número de Equipo</label>
        <input type="text" required class="form-control" id="numeroActivo" placeholder="Número de equipo" v-model="equipo.numeroActivo">
      </div>

      <div class="mb-3">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" required class="form-control" id="marca" placeholder="Marca del equipo" v-model="equipo.marca">
      </div>

      <div class="mb-3">
        <label for="modelo" class="form-label">Modelo</label>
        <input type="text" required class="form-control" id="modelo" placeholder="Modelo del equipo" v-model="equipo.modelo"
        >
      </div>

      <div class="mb-3">
        <label for="codigoUbicacion" class="form-label">Código de Ubicación</label>
        <input type="text" required class="form-control" id="codigoUbicacion" placeholder="Código de ubicación" v-model="equipo.codigoUbicacion">
      </div>

      <div class="mb-3">
        <label for="codigoResponsable" class="form-label">Código de Responsable</label>
        <input type="text" required class="form-control" id="codigoResponsable" placeholder="Código de responsable" v-model="equipo.codigoResponsable">
      </div>

      <div class="btn-group" role="group" aria-label="Grupo básico">
        <button type="submit" class="btn btn-success">Guardar</button>
        <router-link to="/listaE" class="btn btn-warning">Cancelar</router-link>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      equipo: {
      }
    }
  },
  created() {
    this.obtenerEquipo()
  },
  methods: {
    obtenerEquipo() {
      let idEquipo = this.$route.params.id
      fetch('http://localhost/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?consultar=' + idEquipo)
        .then(res => res.json())
        .then(data => {
          console.log(data)
          this.equipo = data[0]
        })
        .catch(err => console.error(err))
    },
    actualizarEquipo() {
      let datosEnviar = {
        id: this.equipo.id,
        numeroActivo: this.equipo.numeroActivo,
        marca: this.equipo.marca,
        modelo: this.equipo.modelo,
        codigoUbicacion: this.equipo.codigoUbicacion,
        codigoResponsable: this.equipo.codigoResponsable
      }

      fetch('http://localhost/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?actualizar=1', {
        method: 'POST',
        body: JSON.stringify(datosEnviar)
      })
        .then(res => res.json())
        .then(data => {
          console.log(data)
          window.location.href = '../listaE'
        })
    }
  }
}
</script>
