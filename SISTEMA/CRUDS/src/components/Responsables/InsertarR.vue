<template>
  <div class="editarr-overlay">
    <div class="background-blur">
      <ListaR />
    </div>

    <div class="editarr-form-container">
      <form v-on:submit.prevent="agregarResponsable">
        <div class="mb-3">
          <label for="codigoAsignado" class="form-label">Código Asignado</label>
          <input type="text" required class="form-control" id="codigoAsignado" v-model="responsable.codigoAsignado"/>
        </div>

        <div class="mb-3">
          <label for="documento" class="form-label">Documento</label>
          <input type="text" required class="form-control" id="documento" v-model="responsable.documentoIdentidad"/>
        </div>

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" required class="form-control" id="nombre" v-model="responsable.nombre"/>
        </div>

        <div class="mb-3">
          <label for="apellido" class="form-label">Apellido</label>
          <input type="text" required class="form-control" id="apellido" v-model="responsable.apellido"/>
        </div>

        <div class="mb-3">
          <label for="cargo" class="form-label">Cargo</label>
          <input type="text" required class="form-control" id="cargo" v-model="responsable.cargo"/>
        </div>

        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="tel" required class="form-control" id="telefono" v-model="responsable.telefono"/>
        </div>

        <button type="submit" class="btn-custom btn-guardar">Guardar</button>
        <router-link to="/listaR" class="btn-custom btn-cancelar">Cancelar</router-link>
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
    methods: {
      agregarResponsable() {
        let datosEnviar = {
          codigoAsignado: this.responsable.codigoAsignado,
          documentoIdentidad: this.responsable.documentoIdentidad,
          nombre: this.responsable.nombre,
          apellido: this.responsable.apellido,
          cargo: this.responsable.cargo,
          telefono: this.responsable.telefono
        };

        fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Responsables.php?insertar=1', {
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
            alert("✅ Responsable registrado correctamente.");
            this.$router.push('/listaR');
          } else {
            // 🎯 ERROR DE LÓGICA (Ej. código 1062)
            alert("ERROR: " + (data.error || "No se pudo completar la operación (Error desconocido en el servidor)."));
            this.responsable.codigoAsignado = '';
          }
        })
        .catch(err => {
          // Si llegamos aquí, es un error de red o el error HTTP lanzado arriba.
          console.error('Error final al insertar responsable:', err);
          alert('⚠️ Error de conexión. Revisa la consola para más detalles.');
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
    box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
    padding: 2.5rem 2rem 2rem 2rem;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 70px;
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
    display: block;
    width: 100%;
    padding: 15px 30px;
    font-size: 1.25rem;
    font-weight: bold;
    line-height: 1.5;
    border-radius: 50px;
    text-decoration: none;
    text-align: center;
    box-sizing: border-box;
    border: none;
    cursor: pointer;
    margin-bottom: 10px;
  }
  
  .btn-guardar {
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
  