<template>
  <div class="editaru-overlay">
    <div class="background-blur">
      <ListaU />
    </div>
    <div class="editaru-form-container">
      <form v-on:submit.prevent="agregarUbicacion" class="editaru-form">
        <div class="mb-3">
          <label for="codigoAsignado" class="form-label">Código Asignado</label>
          <input type="text" required class="form-control" id="codigoAsignado" v-model="ubicacion.codigoAsignado">
        </div>
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" required class="form-control" id="nombre" v-model="ubicacion.nombre">
        </div>
        <div class="mb-3">
          <label for="ubicacion" class="form-label">Ubicación</label>
          <input type="text" required class="form-control" id="ubicacion" v-model="ubicacion.ubicacion">
        </div>
        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="tel" required class="form-control" id="telefono" v-model="ubicacion.telefono">
        </div>
        <button type="submit" class="btn-custom btn-guardar">Guardar</button>
        <router-link to="/listaU" class="btn-custom btn-cancelar">Cancelar</router-link>
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
  methods: {
    agregarUbicacion() {
      let datosEnviar = {
        codigoAsignado: this.ubicacion.codigoAsignado,
        nombre: this.ubicacion.nombre,
        ubicacion: this.ubicacion.ubicacion,
        telefono: this.ubicacion.telefono
      }
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php?insertar=1', {
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
.mb-3 {
  margin-bottom: 1rem !important;
}
.form-label {
  font-weight: bold;
  color: #6c858a;
  margin-bottom: 0.3rem;
  font-size: 1.1rem;
}
.form-control {
  border: none;
  border-bottom: 2px solid #6c858a;
  outline: none;
  background: transparent;
  font-size: 1.1rem;
  padding: 0.3rem 0;
  color: #2c3e50;
  transition: border-color 0.2s;
  border-radius: 0;
  box-shadow: none;
}
.form-control:focus {
  border-bottom: 2.5px solid #3e5660;
  background: transparent;
  box-shadow: none;
}

/* Botones personalizados */
.btn-custom {
  width: 100%;
  border: none;
  border-radius: 32px;
  padding: 0.9rem 0;
  font-size: 1.3rem;
  font-weight: bold;
  text-align: center;
  margin-bottom: 1rem;
  cursor: pointer;
  display: block;
  transition: background 0.2s, color 0.2s;
  text-decoration: none;
}
.btn-guardar {
  background: #6c858a;
  color: #fff;
}
.btn-guardar:hover {
  background: #4d5e65;
}
.btn-cancelar {
  background: #b7c9cc;
  color: #6c858a;
}
.btn-cancelar:hover {
  background: #cfd8dc;
  color: #4d5e65;
}
</style>