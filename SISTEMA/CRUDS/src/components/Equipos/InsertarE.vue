<template>
  <div class="container">
    <form v-on:submit.prevent="agregarEquipo">
      <div class="mb-3">
        <label for="numeroActivo" class="form-label">Número de Equipo</label>
        <input type="text" required class="form-control" id="numeroActivo" placeholder="Número de equipo" v-model="equipo.numeroActivo">
      </div>

      <div class="mb-3">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" required class="form-control" id="marca" placeholder="Marca del equipo" v-model="equipo.marca"
        >
      </div>

      <div class="mb-3">
        <label for="modelo" class="form-label">Modelo</label>
        <input type="text" required class="form-control" id="modelo" placeholder="Modelo del equipo" v-model="equipo.modelo">
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
  methods: {
    agregarEquipo() {
      console.log(this.equipo)

      let datosEnviar = {
        numeroActivo: this.equipo.numeroActivo,
        marca: this.equipo.marca,
        modelo: this.equipo.modelo,
        codigoUbicacion: this.equipo.codigoUbicacion,
        codigoResponsable: this.equipo.codigoResponsable
      }

    fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?insertar=1', {
        method: 'POST',
        body: JSON.stringify(datosEnviar)
    })
    .then(res => res.json())
    .then(data => {
        console.log(data)
        alert('Responsable agregado')
        window.location.href = 'ListaE'
    })
    .catch(err => console.error('Error en la petición:', err))
    }
  }
}
</script>
