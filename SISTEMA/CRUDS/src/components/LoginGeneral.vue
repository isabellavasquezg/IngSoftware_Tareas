<template>
  <div class="login-page">
    <div class="container-fluid h-100">
      <div class="row h-100">
        
        <div class="col-md-7 d-none d-md-block p-0">
          <div class="background-section d-flex align-items-center justify-content-center">
            <div class="bio-banner text-center p-3">
              <h1 class="text-white fw-bold">BioSoftware</h1>
              <p class="text-white mb-0">Sistema de Gestión Tecnológica IPS</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-5 d-flex align-items-center justify-content-center">
          <div class="login-form-container p-4">
            <h2 class="text-center mb-4">User Login</h2>
            
            <form @submit.prevent="login">
              <div class="input-group mb-4 custom-input">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                <input type="text" class="form-control" placeholder="Usuario" required v-model="username">
              </div>
              
              <div class="input-group mb-4 custom-input">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control" placeholder="Contraseña" required v-model="password">
              </div>

              <div v-if="errorMessage" class="alert alert-danger p-2 mb-3">
                {{ errorMessage }}
              </div>
              
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg custom-login-btn">Login</button>
              </div>
            </form>
            
          </div>
        </div>
        
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'LoginGeneral', 
    data() {
        return {
            username: '',
            password: '',
            errorMessage: '',
            // Ajustado para usar la API_URL definida en data
            API_URL: 'http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/usuarios.php' 
        };
    },
    methods: {
        login() {
            this.errorMessage = ''; 

            if (!this.username || !this.password) {
                this.errorMessage = "Por favor, ingresa usuario y contraseña.";
                return;
            }

            fetch(this.API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify({ 
                    "usuario": this.username, 
                    "contraseña": this.password 
                })
            })
            .then(response => {
                // Manejo crucial de errores HTTP antes de procesar el JSON
                if (response.status === 401 || response.status === 400) {
                    return response.json(); 
                }
                if (!response.ok) {
                    throw new Error(response.statusText || 'Error de red.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log("Login Exitoso:", data.message);
                    
                    // Redirección nativa (sin usar Vue Router)
                    window.location.href = '/home'; 
                } else {
                    this.errorMessage = data.message || "Usuario o contraseña incorrectos.";
                }
            })
            .catch(error => {
                console.error("Error de Login/Red:", error);
                this.errorMessage = `Error de conexión: ${error.message}`;
            });
        }
    }
};
</script>

---

<style scoped>
    /* 1. Contenedor principal para ocupar toda la altura de la vista */
    .login-page {
    height: 100vh; 
    overflow: hidden; 
    }
    .container-fluid.h-100, .row.h-100 {
    height: 100%;
    }

    /* 2. Estilos para la Columna de la Imagen (Izquierda) - IMAGEN RESTAURADA */
    .background-section {
    height: 100%;
    /* RUTA DE TU IMAGEN: Asegúrate de que esta ruta sea correcta */
    background-image: url('Imagenes/imagen_fondo_quirofano.png'); 
    background-size: cover;
    background-position: center;
    position: relative;
    }

    /* 3. Estilos para el Banner BioSoftware */
    .bio-banner {
    background-color: rgba(60, 60, 60, 0.7); 
    border-radius: 8px;
    }
    .bio-banner h1, .bio-banner p {
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); 
    }

    /* 4. Estilos para el Formulario (Derecha) */
    .login-form-container {
    width: 90%; 
    max-width: 400px; 
    }

    /* 5. Estilos para los Inputs */
    .custom-input .input-group-text {
    background-color: #e9ecef; 
    border-right: none;
    color: #495057; 
    padding: 0.75rem 1rem; 
    border-top-left-radius: 0.5rem;
    border-bottom-left-radius: 0.5rem;
    }
    .custom-input .form-control {
    border-left: none;
    padding: 0.75rem 1rem; 
    height: auto;
    }

    /* 6. Estilos para el Botón Login */
    .custom-login-btn {
    background-color: #3b5998; 
    border: none;
    padding: 0.75rem;
    font-weight: bold;
    }
    .custom-login-btn:hover {
    background-color: #2d4373;
    }
</style>