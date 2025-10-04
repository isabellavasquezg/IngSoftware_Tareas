<template>
  <div class="login-container">
    <div class="left-panel">
      <div class="branding-background-box"> 
        <div class="logo-text">BioSoftware</div>
        <div class="slogan-text">Sistema de Gestión Tecnológica IPS</div>
      </div>
    </div>

    <div class="right-panel">
      <div class="login-box-wrapper">
        <div class="login-box">
          <div class="user-login-header">User Login</div>
          <div class="user-icon-wrapper">
            <img src="../../Imagenes/user_logo.png" alt="User Icon" class="user-icon" />
          </div>
          <form @submit.prevent="Login" class="login-form">
          <input type="text" placeholder="User Name" class="input-field" v-model="username" />
          <input type="password" placeholder="Password" class="input-field" v-model="password" />
          <button type='submit' class="login-button">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
    // Nombre del componente Vue
    name: 'LoginGeneral', 
    
    // Función que inicializa las variables reactivas del componente (Estado)
    data() {
        return {
            // Variables enlazadas a los inputs mediante v-model
            username: '',
            password: '',
            
            // Variable para mostrar mensajes de error al usuario
            errorMessage: '',
            
            // URL de la API a la que se enviará la solicitud de inicio de sesión
            API_URL: 'http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/usuarios.php' 
        };
    },
    
    // Objeto que contiene las funciones que pueden ser llamadas por la plantilla
    methods: {
        // Función principal de inicio de sesión, llamada al enviar el formulario
        Login() {
            // Limpia cualquier mensaje de error anterior
            this.errorMessage = ''; 

            // **Validación simple del lado del cliente:**
            if (!this.username || !this.password) {
                this.errorMessage = "Por favor, ingresa usuario y contraseña.";
                return; // Detiene la ejecución si faltan campos
            }

            // **Inicio de la solicitud HTTP (Fetch API) a la API PHP:**
            fetch(this.API_URL, {
                method: 'POST', // Método HTTP para enviar datos
                headers: {
                    'Content-Type': 'application/json' // Indica que el cuerpo de la solicitud es JSON
                },
                body: JSON.stringify({ // Convierte los datos del formulario a formato JSON
                    "usuario": this.username, 
                    "contraseña": this.password 
                })
            })
            
            // 1. Manejo de la respuesta HTTP
            .then(response => {
                // Si el estado HTTP es 401 (No autorizado) o 400 (Mala solicitud), 
                // procesa la respuesta como JSON para obtener el mensaje de error del servidor.
                if (response.status === 401 || response.status === 400) {
                    return response.json(); 
                }
                // Si el estado no es 2xx, lanza un error de red
                if (!response.ok) {
                    throw new Error(response.statusText || 'Error de red.');
                }
                // Si la respuesta es exitosa (2xx), procesa el JSON
                return response.json();
            })
            
            // 2. Manejo de los datos de la respuesta (payload JSON)
            .then(data => {
                if (data.success) {
                    // Si el servidor indica éxito
                    console.log("Login Exitoso:", data.message);
                    
                    // Redirección del navegador a la ruta de la lista (ej. Dashboard)
                    window.location.href = '/listaE'; 
                } else {
                    // Si el servidor indica fallo (pero con respuesta HTTP 200, 400 o 401)
                    this.errorMessage = data.message || "Usuario o contraseña incorrectos.";
                }
            })
            
            // 3. Manejo de errores de red o errores lanzados en .then()
            .catch(error => {
                console.error("Error de Login/Red:", error);
                this.errorMessage = `Error de conexión: ${error.message}`;
            });
        }
    }
};
</script>
<style scoped>
/*
|--------------------------------------------------------------------------
| ESTRUCTURA PRINCIPAL Y PANELES (2/3 y 1/3)
|--------------------------------------------------------------------------
*/
.login-container {
    display: flex; /* Usa Flexbox para la disposición de columnas */
    width: 100vw; /* Ancho de la ventana */
    height: 100vh; /* Altura de la ventana (pantalla completa) */
    overflow: hidden;
}

.left-panel {
    flex: 2; /* Asigna 2 partes de 3 (2/3 del ancho total) */
    background-image: url('../../Imagenes/background_login.png'); /* Fondo sin difuminar */
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center; /* Centra el contenido horizontalmente */
    align-items: center; /* Centra el contenido verticalmente */
}

.right-panel {
    flex: 1; /* Asigna 1 parte de 3 (1/3 del ancho total) */
    background-image: url('../../Imagenes/background_login2.png'); /* Fondo difuminado */
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
}

/*
|--------------------------------------------------------------------------
| ESTILOS DE BRANDING: EL NUEVO "CUADRO AZUL"
|--------------------------------------------------------------------------
*/
.branding-background-box {
    background-color: #315280; /* Fondo azul oscuro semi-transparente para el branding */
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
    color: #fff;
    text-align: center;
}

.logo-text {
    font-size: 4.5em; /* Tamaño grande para el nombre */
    font-weight: 700;
}

.slogan-text {
    font-size: 1.6em;
    opacity: 0.9;
}

/*
|--------------------------------------------------------------------------
| ESTILOS DEL CUADRO DE LOGIN
|--------------------------------------------------------------------------
*/

.login-box-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-box {
    /* Efecto "Glassmorphism" con transparencia y desenfoque */
    background: rgba(101, 140, 179, 0.1); 
    backdrop-filter: blur(10px); /* Desenfoque del fondo */
    border: 1px solid rgba(255, 255, 255, 0.6); /* Borde claro */
    border-radius: 30px;
    padding: 40px;
    width: 80%; 
    max-width: 320px;
    color: #fff;
    display: flex; /* Usa Flexbox para organizar el contenido verticalmente */
    flex-direction: column;
    align-items: center;
    gap: 15px; /* Espacio entre los elementos (header, icon, form) */
}

.login-form {
    width: 100%; /* El formulario ocupa todo el ancho disponible */
    display: flex;
    flex-direction: column; /* Apila inputs y botón */
    align-items: center;
    gap: 15px; /* Espacio entre los elementos del formulario */
}

.user-login-header {
    font-size: 1.8em;
    color: #dff1f7;
}

.user-icon-wrapper {
    background-color: rgba(255, 255, 255, 0); /* Fondo semi-transparente para el círculo */
    border-radius: 50%; /* Forma circular */
    padding: 0px;
}

.user-icon {
    width: 100px; 
    opacity: 0.5
}

.input-field {
    width: 90%;
    padding: 12px 10px;
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 15px;
    background-color: rgba(255, 255, 255, 0.15);
    color: #fff; /* Asegura que el texto escrito sea blanco */
    font-size: 1.05em;
    outline: none;
}

.input-field::placeholder {
    color: rgba(255, 255, 255, 0.75); /* Color de la pista */
}

.input-field:focus {
    border-color: #a0d9ff; /* Efecto al enfocar */
    box-shadow: 0 0 8px rgba(160, 217, 255, 0.5);
}

.login-button {
    width: 90%;
    padding: 12px 20px;
    background-color: #658cb3; /* Color azul para el botón */
    border: none;
    border-radius: 20px;
    color: white;
    font-size: 1.2em;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.login-button:hover {
    background-color: #31b0d5; /* Cambio de color al pasar el mouse */
    transform: translateY(-2px);
}
</style>