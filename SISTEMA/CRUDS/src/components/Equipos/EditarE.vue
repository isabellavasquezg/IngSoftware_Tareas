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
          <label for="codigoUbicacion" class="form-label">Ubicación</label>
          <select required class="form-control" id="codigoUbicacion" v-model="equipo.codigoUbicacion">
            <option disabled value="">Seleccione una Ubicación</option>
            <option
              v-for="ubicacion in ubicacionesList"
              :key="ubicacion.codigoAsignado"
              :value="ubicacion.codigoAsignado"
            >
              {{ ubicacion.nombre }} : {{ ubicacion.ubicacion }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="codigoResponsable" class="form-label">Responsable</label>
          <select required class="form-control" id="codigoResponsable" v-model="equipo.codigoResponsable">
            <option disabled value="">Seleccione un Responsable</option>
            <option
              v-for="responsable in responsablesList"
              :key="responsable.codigoAsignado"
              :value="responsable.codigoAsignado"
            >
              {{ responsable.cargo }}: {{ responsable.nombre }} {{ responsable.apellido }}
            </option>
          </select>
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
      },
      ubicacionesList: [], 
      responsablesList: [],
    }
  },
  created() {
    this.obtenerEquipo()
  },
  methods: {
    async obtenerUbicaciones() {
      try {
        // **Reemplaza esta URL** con la de tu API que devuelve todas las ubicaciones
        const response = await fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php'); 
        this.ubicacionesList = await response.json();
      } catch (error) {
        console.error('Error al obtener ubicaciones:', error);
      }
    },
    
    async obtenerResponsables() {
      try {
        // **Reemplaza esta URL** con la de tu API que devuelve todos los responsables
        const response = await fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Responsables.php'); 
        this.responsablesList = await response.json();
      } catch (error) {
        console.error('Error al obtener responsables:', error);
      }
    }, 
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
    // 1. Prepara los datos a enviar
    let datosEnviar = {
        id: this.equipo.id,
        numeroActivo: this.equipo.numeroActivo,
        marca: this.equipo.marca,
        modelo: this.equipo.modelo,
        codigoUbicacion: this.equipo.codigoUbicacion,
        codigoResponsable: this.equipo.codigoResponsable
    }

    // 2. Ejecuta la petición FETCH con manejo de errores mejorado
    fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Equipos.php?actualizar=1', {
        method: 'POST',
        body: JSON.stringify(datosEnviar)
    })
    .then(res => {
        // PASO 1: Validar si la respuesta HTTP es exitosa (código 200-299)
        if (!res.ok) {
            // Si hay un error HTTP, registramos y lanzamos un error
            return res.text().then(text => {
                console.error('Error HTTP. Respuesta del servidor:', text);
                throw new Error("Fallo en la comunicación con la API. Código: " + res.status);
            });
        }
        // Si es OK, intentamos parsear el JSON
        return res.json();
    })
    .then(data => {
        // PASO 2: Manejamos la respuesta JSON (éxito o error de lógica de la BD)
        console.log(data); // Para debug

        if (data.success === 1) {
            // ÉXITO
            alert("✅ Equipo actualizado correctamente.");
            // Enrutamos/Redirigimos
            this.$router.push('/listaE'); 
            // Alternativa si usas redirección pura: window.location.href = '../listaE'

        } else {
            // ERROR DE LÓGICA (Ej. ID no encontrado, clave única duplicada, campos faltantes)
            const errorMessage = data.error || "No se pudo completar la actualización (Error desconocido en el servidor).";
            alert("❌ ERROR al actualizar: " + errorMessage);
            
            // Opcional: limpiar el campo duplicado para que el usuario lo corrija
            if (errorMessage.includes('ya existe') && errorMessage.includes(this.equipo.numeroActivo)) {
                 this.equipo.numeroActivo = ''; // Limpia solo el campo que causó el conflicto
            }
        }
    })
    .catch(err => {
        // Manejo de error de red (no se pudo conectar) o error HTTP/parsing
        console.error('Error final al actualizar equipo:', err);
        alert('⚠️ El Equipo con este codigo ya existe no puede haber dos equipos con el mismo codigo');
    });
  }
  },
  mounted() {
  this.obtenerUbicaciones();
  this.obtenerResponsables();
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
.form-control{
  border: none;
  border-bottom: 2px solid #0c5b94;
  outline: none;
  background: transparent;
  font-size: 1.1rem;
  padding: 0.3rem 0;
  color: #0c5b94;
  transition: border-color 0.2s;
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
