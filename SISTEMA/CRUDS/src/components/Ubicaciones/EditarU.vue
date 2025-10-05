<template>
  <div class="editaru-overlay">
    <div class="background-blur">
      <ListaU />
    </div>
    <div class="editaru-form-container">
      <form v-on:submit.prevent="actualizarUbicacion" class="editaru-form">
        <div class="form-group">
          <label for="codigoAsignado">Código Asignado</label>
          <input type="text" required id="codigoAsignado" v-model="ubicacion.codigoAsignado" />
        </div>
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" required id="nombre" v-model="ubicacion.nombre" />
        </div>
        <div class="form-group">
          <label for="ubicacion">Ubicación</label>
          <input type="text" required id="ubicacion" v-model="ubicacion.ubicacion" />
        </div>
        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="tel" required id="telefono" v-model="ubicacion.telefono" />
        </div>
        <button type="submit" class="btn-agregar">Guardar</button>
        <router-link to="/listaU" class="btn-cancelar">Cancelar</router-link>
      </form>
    </div>
  </div>
</template>

<script>
import ListaU from './ListaU.vue'
export default {
  components: { ListaU },
  data() {
    return {
      ubicacion: {}
    }
  },
  created() {
    this.obtenerUbicacion();
  },
  methods: {
    obtenerUbicacion() {
      let idUbicacion = this.$route.params.id;
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php?consultar=' + idUbicacion)
        .then(res => res.json())
        .then(data => {
          this.ubicacion = data[0];
        })
        .catch(err => { console.error(err); });
    },
    actualizarUbicacion() {
      let datosEnviar = {
        id: this.ubicacion.id,
        codigoAsignado: this.ubicacion.codigoAsignado,
        nombre: this.ubicacion.nombre,
        ubicacion: this.ubicacion.ubicacion,
        telefono: this.ubicacion.telefono
      }
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php?actualizar=1', {
        method: 'POST',
        body: JSON.stringify(datosEnviar)
      })
        .then(res => res.json())
        .then(() => {
          this.$router.push('/listaU');
        })
    }
  }
}
</script>

<style scoped>
.editaru-overlay {
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
.editaru-form-container {
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
.editaru-form {
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