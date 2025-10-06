<template>
  <div class="editarr-overlay">
    <div class="background-blur">
      <ListaR />
    </div>

    <div class="editarr-form-container">
      <form v-on:submit.prevent="actualizarResponsable" class="editarr-form">
        <div class="form-group">
          <label for="codigoAsignado">Código Asignado</label>
          <input type="text" required id="codigoAsignado" v-model="responsable.codigoAsignado" />
        </div>

        <div class="form-group">
          <label for="documento">Documento</label>
          <input type="text" required id="documento" v-model="responsable.documentoIdentidad" />
        </div>

        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" required id="nombre" v-model="responsable.nombre" />
        </div>

        <div class="form-group">
          <label for="apellido">Apellido</label>
          <input type="text" required id="apellido" v-model="responsable.apellido" />
        </div>

        <div class="form-group">
          <label for="cargo">Cargo</label>
          <input type="text" required id="cargo" v-model="responsable.cargo" />
        </div>

        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="tel" required id="telefono" v-model="responsable.telefono" />
        </div>

        <button type="submit" class="btn-agregar">Guardar</button>
        <router-link to="/listaR" class="btn-cancelar">Cancelar</router-link>
      </form>
    </div>
  </div>
</template>
  
<script>
import ListaR from './ListaR.vue'
export default {
  components: { ListaR },
  data() {
    return {
      responsable: {}
    }
  },
  created() {
    this.obtenerResponsable();
  },
  methods: {
    obtenerResponsable() {
      let idResponsable = this.$route.params.id;
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Responsables.php?consultar=' + idResponsable)
        .then(res => res.json())
        .then(data => {
          this.responsable = data[0];
        })
        .catch(err => { console.error(err); });
    },
  actualizarResponsable() {
    let datosEnviar = {
        id: this.responsable.id,
        codigoAsignado: this.responsable.codigoAsignado,
        documentoIdentidad: this.responsable.documentoIdentidad,
        nombre: this.responsable.nombre,
        apellido: this.responsable.apellido,
        cargo: this.responsable.cargo,
        telefono: this.responsable.telefono
    };

    fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Responsables.php?actualizar=1', {
        method: 'POST',
        body: JSON.stringify(datosEnviar)
    })
    .then(res => {
        // PASO 1: Validar si la respuesta HTTP es exitosa (código 200-299)
        if (!res.ok) {
            return res.text().then(text => {
                console.error('Error HTTP. Respuesta del servidor:', text);
                throw new Error("Fallo en la comunicación con la API. Código: " + res.status);
            });
        }
        // Si es OK, intentamos parsear el JSON
        return res.json();
    })
    .then(data => {
        // PASO 2: Manejamos la respuesta JSON (éxito o error de lógica)
        console.log("Respuesta del servidor:", data);

        if (data.success === 1) {
            // ÉXITO
            alert("✅ Responsable actualizado correctamente.");
            this.$router.push('/listaR'); 

        } else {
            // ERROR DE LÓGICA (Ej. campos faltantes o error de BD)
            const errorMessage = data.error || "No se pudo completar la operación (Error desconocido en el servidor).";
            alert("❌ ERROR al actualizar: " + errorMessage);
        }
    })
    .catch(err => {
        // Manejo de error de red o error HTTP/parsing
        console.error('Error final al actualizar responsable:', err);
        alert('⚠️ error el responsable ya existe en la base de datos');
    });
  }
  }
}
</script>

<style scoped>
.editarr-overlay {
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
.editarr-form-container {
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
.editarr-form {
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
  transition: background 0.2s, color 0.2s;
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
  transition: background 0.2s, color 0.2s;
}
.btn-cancelar:hover {
  background: #ffffff;
  color: #0c5b94;
}
</style>  