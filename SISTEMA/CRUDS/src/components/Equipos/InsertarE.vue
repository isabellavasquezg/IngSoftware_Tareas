<template>
   <div class="editare-overlay">
    <div class="background-blur">
      <ListaE />
    </div>
    <div class="editare-form-container">
      <form v-on:submit.prevent="agregarEquipo">
        <div class="mb-3">
          <label for="numeroActivo" class="form-label">Número de Equipo</label>
          <input type="text" required class="form-control" id="numeroActivo" v-model="equipo.numeroActivo">
        </div>

        <div class="mb-3">
          <label for="marca" class="form-label">Marca</label>
          <input type="text" required class="form-control" id="marca"  v-model="equipo.marca">
        </div>

        <div class="mb-3">
          <label for="modelo" class="form-label">Modelo</label>
          <input type="text" required class="form-control" id="modelo" v-model="equipo.modelo">
        </div>

        <div class="mb-3">
          <label for="codigoUbicacion" class="form-label">Código de Ubicación</label>
          <input type="text" required class="form-control" id="codigoUbicacion" v-model="equipo.codigoUbicacion">
        </div>

        <div class="mb-3">
          <label for="codigoResponsable" class="form-label">Código de Responsable</label>
          <input type="text" required class="form-control" id="codigoResponsable" v-model="equipo.codigoResponsable">
        </div>
        <button type="submit" class="btn-custom btn-guardar">Guardar</button>
        <router-link to="/listaE" class="btn-custom btn-cancelar">Cancelar</router-link>
      </form>
    </div>
  </div>
</template>

<script>
import ListaE from './ListaE.vue'

// Si usas Vue Router (recomendado), ListaE.vue debe estar en la ruta '/listaE'
// Si no usas Vue Router, puedes mantener window.location.href, pero la versión con $router es más limpia.

export default {
  components: { ListaE },
  data() {
    return {
      equipo: {
      }
    }
  },
  methods: {
    agregarEquipo() {
      // 1. Prepara los datos a enviar
      let datosEnviar = {
        numeroActivo: this.equipo.numeroActivo,
        marca: this.equipo.marca,
        modelo: this.equipo.modelo,
        codigoUbicacion: this.equipo.codigoUbicacion,
        codigoResponsable: this.equipo.codigoResponsable
      }
      console.log(datosEnviar)
      // 2. Ejecuta la petición FETCH con manejo de errores mejorado
      fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?insertar=1', {
        method: 'POST',
        body: JSON.stringify(datosEnviar)
      })
      .then(res => {
        // PASO 1: Validar si la respuesta HTTP es exitosa (código 200-299)
        if (!res.ok) {
          return res.text().then(text => {
            console.error('Error HTTP. Respuesta del servidor:', text)
            throw new Error("Fallo en la comunicación con la API. Código: " + res.status)
          })
        }
        // Si es OK, intentamos parsear el JSON
        return res.json()
      })
      .then(data => {
        // PASO 2: Manejamos la respuesta JSON (éxito o error de lógica)
        if (data.success === 1) {
          // ÉXITO
          alert("✅ Equipo registrado correctamente.")
          this.$router.push('/listaE') 
 
        } else {
          // ERROR DE LÓGICA (Ej. campos faltantes o error de BD)
          alert("❌ ERROR: " + (data.error || "No se pudo completar la operación (Error desconocido en el servidor)."))
          // Opcional: limpiar un campo específico si es un error de duplicado (no implementado en tu PHP actual)
          // this.equipo.numeroActivo = '' 
        }
      })
      .catch(err => {
        // Manejo de error de red o error HTTP/parsing
        console.error('Error final al insertar equipo:', err)
        alert('⚠️ Error de conexión o comunicación. Revisa la consola para más detalles.')
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
