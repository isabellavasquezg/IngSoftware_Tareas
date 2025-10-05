<template>
    <div class="editare-overlay">
      <div class="background-blur">
        <ListaE />
      </div>
    <div class="editare-form-container">
      <form v-on:submit.prevent="actualizarEquipo">
        <div class="form-group">
          <label for="numeroActivo" class="form-label">Número de Equipo</label>
          <input type="text" required  id="numeroActivo" v-model="equipo.numeroActivo">
        </div>

        <div class="form-group">
          <label for="marca" class="form-label">Marca</label>
          <input type="text" required  id="marca"  v-model="equipo.marca">
        </div>

        <div class="form-group">
          <label for="modelo" class="form-label">Modelo</label>
          <input type="text" required  id="modelo"  v-model="equipo.modelo" >
        </div>

        <div class="form-group">
          <label for="codigoUbicacion" class="form-label">Código de Ubicación</label>
          <input type="text" required  id="codigoUbicacion" v-model="equipo.codigoUbicacion">
        </div>

        <div class="form-group">
          <label for="codigoResponsable" class="form-label">Código de Responsable</label>
          <input type="text" required  id="codigoResponsable" v-model="equipo.codigoResponsable">
        </div>

        <button type="submit" class="btn-agregar">Guardar</button>
        <router-link to="/listaE" class="btn-cancelar">Cancelar</router-link>
      </form>
    </div>
  </div>
</template>

<script>
import ListaE from './ListaE.vue'
export default {
  components: { ListaE },
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
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?consultar=' + idEquipo)
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

      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?actualizar=1', {
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
<style scoped>
.editare-overlay {
  position: fixed;
  inset: 0;
  z-index: 1000;
}
.background-blur {
  position: absolute;
  inset: 0;
  filter: brightness(0.7) blur(1px);
  pointer-events: none;
}
.editare-form-container {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  max-width: 95vw;
  transform: translate(-50%, -50%);
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px rgba(44,62,80,0.18);
  padding: 2.5rem 2rem 2rem 2rem;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.editare-form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
}
.form-group {
  display: flex;
  flex-direction: column;
  align-items: stretch;
}
.form-group label {
  font-weight: bold;
  color: #0c5b94;
  margin-bottom: 0.3rem;
  font-size: 1.1rem;
}
.form-group input {
  border: none;
  border-bottom: 2px solid #0c5b94;
  outline: none;
  background: transparent;
  font-size: 1.1rem;
  padding: 0.3rem 0;
  color: #0c5b94;
  transition: border-color 0.2s;
}
.form-group input:focus {
  border-bottom: 2.5px solid #1171b7;
}
.btn-agregar {
  width: 100%;
  background: #0c5b94;
  color: #fff;
  border: none;
  border-radius: 22px;
  padding: 0.7rem 0;
  font-size: 1.2rem;
  font-weight: bold;
  margin-top: 0.7rem;
  margin-bottom: 0.2rem;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-agregar:hover {
  background: #ffffff;
  color: #0c5b94;
}
.btn-cancelar {
  display: block;
  width: 100%;
  text-align: center;
  background: #0c5b94;
  color: #ffffff;
  border-radius: 22px;
  padding: 0.6rem 0;
  font-size: 1.1rem;
  font-weight: bold;
  text-decoration: none;
  margin-top: 0.2rem;
  transition: background 0.2s;
}
.btn-cancelar:hover {
  background: #0c5b94;
  color: #ffffff;
}
</style>
