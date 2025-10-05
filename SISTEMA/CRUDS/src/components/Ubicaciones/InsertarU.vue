<template>
  <div class="editaru-overlay">
    <div class="background-blur">
      <ListaU />
    </div>
    <div class="editaru-form-container">
      <form v-on:submit.prevent="agregarUbicacion">
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
        };

        fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php?insertar=1', {
            method: 'POST',
            body: JSON.stringify(datosEnviar)
        })
        .then(res => {
            // 🎯 Paso 1: Si la respuesta HTTP no es OK (ej. 500, 404), la tratamos como error aquí.
            if (!res.ok) {
                // Lanza un error para ir al bloque catch. Intentamos leer el texto para depurar.
                return res.text().then(text => {
                    console.error('Error HTTP. Respuesta del servidor:', text);
                    throw new Error("Fallo en la comunicación con la API. Código: " + res.status);
                });
            }
            // Si la respuesta es OK (200), intentamos parsear el JSON.
            return res.json();
        })
        .then(data => {
            // Paso 2: Manejamos la respuesta JSON del servidor
            if (data.success === 1) {
                // ÉXITO
                alert("✅ Ubicacion registrado correctamente.");
                this.$router.push('/listaU');
            } else {
                // 🎯 ERROR DE LÓGICA (Ej. código 1062)
                alert("ERROR: " + (data.error || "No se pudo completar la operación (Error desconocido en el servidor)."));
                this.ubicacion.codigoAsignado = '';
            }
        })
        .catch(err => {
            // Si llegamos aquí, es un error de red o el error HTTP lanzado arriba.
            console.error('Error final al insertar ubicación:', err);
            alert('⚠️ Error de conexión. Revisa la consola para más detalles.');
        });
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

.mb-3 {
  margin-bottom: 1rem !important;
}
.form-label {
  font-weight: bold;
  color: #0c5b94;
  margin-bottom: 0.1rem;
  font-size: 1.1rem;
}
.form-control {
  border: none;
  border-bottom: 2px solid #0c5b94;
  outline: none;
  background: transparent;
  font-size: 1.1rem;
  padding: 0.1rem 0;
  color: #0c5b94;
  transition: border-color 0.2s;
  border-radius: 0;
  box-shadow: none;
}
.form-control:focus {
  border-bottom: 2.5px solid #0c5b94;
  background: transparent;
  box-shadow: none;
}

/* Botones personalizados */
.btn-custom {
     /* 🎯 CAMBIOS PARA REDUCIR TAMAÑO */
    width: auto;             /* CLAVE 1: Dejar que el botón se ajuste al contenido (no 100%) */
    padding: 0.9rem 5rem;  /* CLAVE 2: Reducir relleno vertical (0.9rem -> 0.5rem) y añadir horizontal */
    font-size: 1rem;         /* CLAVE 3: Reducir fuente (1.3rem -> 1rem) */
    
    /* 🎯 CAMBIOS PARA CENTRAR */
    margin: 0.6rem auto;       /* CLAVE 4: Centrado horizontal (0 auto) y margen inferior ajustado */
    display: block;          /* Necesario para que margin: auto funcione */
    
    /* Estilos de apariencia */
    border: none;
    border-radius: 32px;
    font-weight: bold;
    text-align: center;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
    text-decoration: none;
}
.btn-guardar {
  margin-bottom: 0;
  background: #0c5b94;
  color: #ffffff;
}
.btn-guardar:hover {
  background: #ffffff;
  color: #0c5b94;
}
.btn-cancelar {
  background: #0c5b94;
  color: #ffffff;
}
.btn-cancelar:hover {
  background: #ffffff;
  color: #0c5b94;
}
</style>