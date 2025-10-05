<template>
  <div class="ubicaciones-page">
    <div class="container-fluid h-100">
      <div class="row h-100">
        <!-- Sidebar Izquierdo -->
        <div class="col-md-3 d-flex flex-column p-0 sidebar">
          <div class="sidebar-content flex-grow-1 d-flex flex-column justify-content-between">
            <!-- Logo + título -->
            <div class="text-center py-4">
              <div class="icono-circular mx-auto mb-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <h2 class="titulo-sidebar">Ubicaciones</h2>
            </div>
            <!-- Opciones -->
            <div class="enlaces-centrales">
              <ul class="list-unstyled">
                <li class="opcion-link">
                  <a href="#" @click.prevent="mostrarBuscador = true" class="enlace-menu">
                    <span>Buscar Ubicación</span>
                  </a>
                </li>
                
                <li class="opcion-link">
                  <router-link :to="{name:'insertarU'}" class="enlace-menu">
                    <span>Nueva Ubicación</span>
                  </router-link>
                </li>
                <li class="opcion-link">
                  <a href="#" @click.prevent="consultarUbicaciones" class="enlace-menu">
                    <span>Todas las ubicaciones</span>
                  </a>
                </li>
                
                </ul>
            </div>
            <!-- Botones inferiores -->
            <div class="botones-inferiores d-flex">
                <div class="dropdown w-50 d-flex align-items-center justify-content-center menu-inferior-dropdown">
                  <button 
                    class="btn btn-icon d-flex align-items-center justify-content-center" 
                    type="button" 
                    id="menuDropdown" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false"
                    style="width: 100%; height: 100%;"
                  >
                    <i class="bi bi-list"></i> 
                  </button>
                  
                  <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="menuDropdown menu-desplegable">
                    <li>
                      <router-link :to="{ name: 'listaE' }" class="dropdown-item List-buttom-menu">
                        <i class="bi bi-pc-display-horizontal " ></i> Equipos
                      </router-link>
                    </li>
                    <li>
                      <router-link :to="{ name: 'listaU' }" class="dropdown-item List-buttom-menu">
                        <i class="bi bi-geo-alt "></i> Ubicaciones
                      </router-link>
                    </li>
                    <li>
                      <router-link :to="{ name: 'listaR' }" class="dropdown-item List-buttom-menu">
                        <i class="bi bi-person-badge "></i> Responsables
                      </router-link>
                    </li>
                  </ul>
                </div>
              <router-link to="/" class="btn btn-icon w-50 d-flex align-items-center justify-content-center">
                <i class="bi bi-power"></i>
              </router-link>
            </div>
          </div>
        </div>
        <!-- Contenido Derecho -->
        <div class="col-md-9 d-flex flex-column p-4">
          <div class="card shadow flex-grow-1">
            <div color="#446b9b" class="card-header text-center">
              <h3 class="mb-0">Listado de Ubicaciones</h3>
            </div>
            <div class="card-body tabla-scroll">
              <!-- Tabla -->
              <div class="table-responsive tabla-contenedor">
                <table class="table table-bordered table-hover align-middle">
                  <thead class="table-secondary">
                    <tr>
                      <th>ID</th>
                      <th>Código Asignado</th>
                      <th>Nombre</th>
                      <th>Ubicación</th>
                      <th>Teléfono</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="ubicacion in ubicacionesFiltradas" :key="ubicacion.id" class="fila-interactiva">
                      <td>{{ ubicacion.id }}</td>
                      <td>{{ ubicacion.codigoAsignado }}</td>
                      <td>{{ ubicacion.nombre }}</td>
                      <td>{{ ubicacion.ubicacion }}</td>
                      <td>{{ ubicacion.telefono }}</td>
                      <td>
                        <div class="btn-group">
                          <router-link :to="{name:'editarU', params:{id: ubicacion.id}}" class="btn btn-warning btn-sm">Editar</router-link>
                          <button type="button" @click="borrarUbicacion(ubicacion.codigoAsignado)" class="btn btn-danger btn-sm">Eliminar</button>
                        </div>
                      </td>
                    </tr>
                    <tr v-if="ubicacionesFiltradas.length === 0">
                      <td colspan="6" class="text-center text-muted">No hay ubicaciones registradas</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Buscador Modal -->
    <div v-if="mostrarBuscador" class="buscador-modal">
      <div class="buscador-form-container">
      <form @submit.prevent="aplicarFiltro" class="buscador-form">
        <div class="form-group">
          <label for="busquedaCodigo" class="form-label">Código Asignado</label>
          <input
            type="text"
            id="busquedaCodigo"
            class="form-control"
            
            v-model="textoBusqueda"  placeholder="Buscar por código asignado..."
            autofocus
          />
        </div>
        <button type="submit" class="btn-buscar">Buscar</button>
        
        <button type="button" @click.prevent="cerrarBuscador" class="btn-buscar">Cerrar </button>
      </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "ListaUbicaciones",
    data() {
        return {
            ubicaciones: [],
            
            // 🎯 NUEVO: Variable temporal enlazada al input del modal
            textoBusqueda: "", 
            
            // 🎯 NUEVO: Variable usada para filtrar la tabla (se actualiza al hacer submit)
            filtroActivo: "", 
            
            mostrarBuscador: false
        }
    },
    created() {
        this.consultarUbicaciones()
    },
    computed: {
        ubicacionesFiltradas() {
            // Usa el filtroActivo para determinar qué mostrar
            if (!this.filtroActivo) return this.ubicaciones

            return this.ubicaciones.filter(u =>
                u.codigoAsignado.toLowerCase().includes(this.filtroActivo.toLowerCase())
            )
        }
    },
    methods: {
        consultarUbicaciones() {
            // Reseteamos las variables de búsqueda al cargar la lista completa
            this.filtroActivo = ""
            this.textoBusqueda = ""
            
            fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php')
                .then(res => res.json())
                .then(data => {
                    if (typeof data[0]?.success === 'undefined') {
                        this.ubicaciones = data
                    } else {
                        this.ubicaciones = []
                    }
                })
                .catch(err => console.error('Error al cargar ubicaciones:', err))
        },
        
        // 🎯 MÉTODO NUEVO: Ejecuta la búsqueda al hacer submit
        aplicarFiltro() {
            // 1. Aplica el texto temporal al filtro real
            this.filtroActivo = this.textoBusqueda;
            
            // 2. Cierra la modal
            this.mostrarBuscador = false;
        },
        
        // El botón "Cerrar" resetea el input temporal sin aplicar el filtro
        cerrarBuscador() {
            // Restaura el input al valor que está actualmente filtrando la tabla
            this.textoBusqueda = this.filtroActivo;
            this.mostrarBuscador = false;
        },
        
        borrarUbicacion(codigoAsignado) {
            if (!confirm("¿Estás seguro de que deseas eliminar esta ubicación?")) {
                return;
            }

            // CLAVE: Usamos codigoAsignado en la URL
            fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php?borrar=' + codigoAsignado)
                .then(res => res.json())
                .then(data => {
                    if (data.success === 1) {
                        // Éxito:
                        alert(data.message || "Ubicación eliminada correctamente.");
                        this.consultarUbicaciones();
                    } else {
                        // Error de restricción de clave foránea (con conteo de equipos)
                        alert(data.error || "No se pudo completar la acción de eliminación.");
                    }
                })
                .catch(err => {
                    console.error('Error al intentar eliminar ubicación:', err);
                    alert('Error de conexión o datos. Revisa la consola.');
                });
        },
        
        // ... otros métodos que puedas tener ...
    }
}
</script>

<style scoped>
.ubicaciones-page {
  height: 100vh;
  overflow: hidden;
}
.sidebar {
  background-color: #315280;
  color: white;
  height: 100vh;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.icono-circular {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background-color: #cfd8dc;
  display: flex;
  align-items: center;
  justify-content: center;
}
.icono-circular i {
  font-size: 50px;
  color: #315280;
}
.titulo-sidebar {
  font-size: 1.8rem;
  font-weight: bold;
  color: #cfd8dc;
}
.enlaces-centrales {
    padding: 10px 0; /* Espacio vertical para la sección de enlaces */
}

.enlaces-centrales ul {
    margin: 0;
    padding: 0 15px; /* Padding horizontal de la lista */
}

/* Elemento de la lista: Añadir separación sin la línea horizontal */
.opcion-link {
    margin-bottom: 5px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.5); /* Línea sutil */
}

/* El enlace (router-link o a) - La clave del estilo profesional */
.enlace-menu {
    /* Diseño y tamaño */
    display: flex;
    justify-content: center; 
    display: flex; /* Permite centrar y alinear el icono y el texto */
    align-items: center;
    padding: 12px 15px; /* Espacio interno generoso para un toque fácil */
    width: 100%;
    
    /* Apariencia */
    color: #ffffffff; /* Texto gris oscuro sutil */
    text-decoration: none;
    font-size: 1rem;
    font-weight: 500; /* Ligeramente más grueso */
    border-radius: 6px; /* Bordes suaves */
    
    /* Transición Profesional: Suaviza todos los efectos */
    transition: all 0.25s ease;
}


/* *** FEEDBACK VISUAL: Hover y Foco *** */
.enlace-menu:hover,
.enlace-menu:focus {
    background-color: #638bb3; /* Fondo azul */
    color: #ffffffff; /* Texto en color primario */
    text-decoration: none;
    outline: none; /* Elimina el borde feo de foco */
    cursor: pointer;
}
.card-header {
    /* 1. Aplicar el color de fondo */
    background-color: #446b9b;
    
    /* 2. Mejorar la legibilidad del texto */
    color: white; /* Cambia el color del texto a blanco para que contraste con el fondo oscuro */
    text-align: center;
    /* 3. Estilo profesional y moderno */
    font-weight: 600; /* Hace el texto más audaz y legible */
    font-size: 1.1rem; /* Aumenta ligeramente el tamaño de la fuente */
    padding: 15px 20px; /* Aumenta el relleno para que se vea más espacioso */
    border-bottom: none; /* Elimina el borde inferior estándar de Bootstrap */
    border-radius: 0.375rem 0.375rem 0 0; /* Asegura que la parte superior de la tarjeta tenga bordes redondeados */
    
    /* 4. Sombra sutil (Opcional, si quieres que se "levante") */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
}
td {
  text-align: left;
}
.table {
    --bs-table-bg: #fff; /* Asegura un fondo blanco para las filas por defecto */
    --bs-table-hover-bg: #e0f0ff; /* Define un hover predeterminado si no quieres el azul oscuro */
    /* ... otros estilos de tabla de Bootstrap ... */
}


/* *** SOLUCIÓN CLAVE: Selector más específico para anular Bootstrap *** */
/* Usamos el contenedor de la tabla para aumentar la especificidad */
.table.table-hover > tbody > .fila-interactiva:hover,
.table > tbody > .fila-interactiva:hover {
    background-color: #073f67 !important; /* Tu color azul oscuro */
    color: white !important; /* El texto debe ser blanco para que sea legible */
    cursor: pointer;
    transition: all 0.2s ease-in-out; /* Transición suave para todos los cambios */
}

/* También asegúrate de que los enlaces/botones dentro de la fila se vean bien */
.table > tbody > .fila-interactiva:hover .btn,
.table > tbody > .fila-interactiva:hover a {
    /* Puedes ajustar el color de los botones o enlaces internos en hover si quieres */
    /* Por ejemplo, hacerlos ligeramente más claros o de otro color para que destaquen */
    filter: brightness(1.2); /* Aclarar los botones ligeramente */
    color: #fff; /* Asegurar que el texto del botón se vea */
}

/* Opcional: Estilo para los iconos si los tuvieras en la fila */
.table > tbody > .fila-interactiva:hover i {
    color: #fff;
}


/* Si tienes la clase `table-hover` directamente en tu `<table>` */
.table-hover tbody tr:hover {
    background-color: #073f67 !important; /* Sobrescribe el hover predeterminado de Bootstrap */
    color: white !important;
}
th{
  background-color:#073f67;
  color: #fff;
}
.tabla-scroll {
  height: calc(100vh - 150px);
  overflow-y: auto;
  background: transparent;
}
.tabla-contenedor {
  max-height: 80vh;
  overflow-y: auto;
}
.botones-inferiores {
  padding: 0;
  background: #b7c9cc;
}
.btn-icon {
    /* Define un color de fondo base y color de texto */
    background-color: #315280; /* Gris claro, similar al de Bootstrap */
    color: #ffffffff; /* Texto gris oscuro */
    border: 1px solid #dee2e6; /* Borde sutil */
    transition: all 0.2s ease-in-out; /* Transición suave para todos los cambios */
    /* Asegura que el botón se vea como tal */
    padding: 10px 15px; /* Relleno adecuado */
    border-radius: 0.25rem; /* Bordes redondeados */
    text-decoration: none; /* Quita el subrayado del router-link */
    
    /* Importante para que el efecto se vea bien */
    box-shadow: 0 3px #adb5bd; /* Sombra sutil para darle relieve */
    transform: translateY(0);
}

/* 2. Efecto al pasar el ratón (Hover) */
.btn-icon:hover {
    background-color: #638bb3; /* Un gris ligeramente más oscuro al pasar el ratón */
    color: #ffffffff; /* Un toque de color azul para realzar la opción */
    cursor: pointer; /* Indica que es interactivo */
}

.botones-inferiores .dropdown-menu {
    /* ... Tus estilos de posicionamiento (bottom, top, etc.) ... */
    
    background-color: #007bff; /* Fondo azul para el menú (similar al de la imagen) */
    
    /* 🎯 CLAVE: Eliminar el borde */
    border: none; 
    
    /* 🎯 CLAVE: Establecer los bordes redondeados a cero (o personalizarlos) */
    border-radius: 0; 
    
    /* Si quieres bordes redondeados solo arriba, podrías hacer: */
    /* border-top-left-radius: 8px; */
    /* border-top-right-radius: 8px; */
    /* border-bottom-left-radius: 0; */
    /* border-bottom-right-radius: 0; */
    
    box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2); /* Una sombra más pronunciada para que "flote" */
    padding: 0; /* Asegura que no haya padding interno que genere un espacio */
    overflow: hidden; /* Corta cualquier contenido que se salga de los bordes redondeados */
}

/* Ajustes para los ítems del menú (si ahora se ven muy pegados) */
.botones-inferiores .dropdown-item {
    color: white; /* Color del texto para que contraste con el fondo azul */
    background-color: #315280; /* Mismo color de fondo que el menú */
    padding: 12px 20px; /* Relleno adecuado */
    transition: background-color 0.2s ease;
}

.botones-inferiores .dropdown-item:hover {
    background-color: #4472b1; /* Un azul ligeramente más oscuro al pasar el ratón */
    color: white;
}

.botones-inferiores .dropdown-item i {
    color: white; /* Asegura que los iconos también sean blancos */
}

/* Línea divisoria si la usas */
.botones-inferiores .dropdown-divider {
    border-top: 1px solid rgba(255, 255, 255, 0.2); /* Divisor blanco translúcido */
    margin: 0; /* Elimina márgenes extra */
}
/* 3. Efecto al presionar (Active) */
.btn-icon:active {
    /* Mueve el botón hacia abajo para simular que se ha presionado */
    transform: translateY(3px); 
    /* Elimina la sombra para simular que ha "entrando" en la superficie */
    box-shadow: 0 0px #adb5bd;
    /* Cambia el color si lo deseas para dar feedback */
    background-color: #dee2e6; 
}
.btn-warning {
  background: #fafafa !important;
  color: #073f67 !important;
  border: none;
}

.btn-danger {
  background: #073f67 !important;
  color: #fff !important;
  border: none;
}
.btn-warning:hover {
  background: #0d61ea !important;
  color: #fbfbfb !important;
}
.btn-danger:hover {
  background: #feffff !important;
  color: #0d61ea !important;
}
/* Buscador Modal */
.buscador-modal {
  position: fixed;
  inset: 0;
  z-index: 2000;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
}
.buscador-form-container {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px rgba(44,62,80,0.18);
  padding: 2.5rem 2rem 2rem 2rem;
  min-width: 350px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.buscador-form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
  align-items: center;
}
.form-group {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: stretch;
}
.form-label {
  font-weight: bold;
  color: #0c5b94;
  margin-bottom: 0.3rem;
  font-size: 1.1rem;
}
.form-control {
  border: none;
  border-bottom: 2px solid #073f67;
  outline: none;
  background: transparent;
  font-size: 1.1rem;
  padding: 0.3rem 0;
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
.btn-buscar {
  width: 80%;
  background: #073f67;
  color: #fff;
  border: none;
  border-radius: 15px;
  padding: 0.6rem 0;
  font-size: 1rem;
  font-weight: bold;
  text-align: center;
  margin-top: 0.2rem;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  text-decoration: none;
}
.btn-buscar:hover {
  background: #4d5e65;
}
</style>
