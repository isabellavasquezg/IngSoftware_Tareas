<template>
    <div class="container">
        <form v-on:submit.prevent="actualizarUbicacion">
            <div class="mb-3">
            <label for="codigoAsignado" class="form-label">Código Asignado</label>
            <input type="text" required class="form-control" id="codigoAsignado" placeholder="Código asignado" v-model="ubicacion.codigoAsignado">
            </div>

            <div class="mb-3">
            <label for="documento" class="form-label">Nombre</label>
            <input type="text" required class="form-control" id="nombre" placeholder="Nombre" v-model="ubicacion.nombre">
            </div>

            <div class="mb-3">
            <label for="nombre" class="form-label">Ubicación</label>
            <input type="text" required class="form-control" id="nombre" placeholder="Ubicación" v-model="ubicacion.ubicacion">
            </div>

            <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" required class="form-control" id="telefono" placeholder="Ej: 999-999-999" v-model="ubicacion.telefono">
            </div>
            <div class="btn-group" role="group" aria-label="Grupo básico">
                <button type="submit" class="btn btn-success">Guardar</button>
                <router-link to="/listaU" class="btn btn-warning">Cancelar</router-link>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            ubicacion: {
            }
        }
    },
    created: function() {
        this.obtenerUbicacion();
    },
    methods:{
        obtenerUbicacion(){
            let idUbicacion = this.$route.params.id;
            fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php?consultar='+idUbicacion)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                this.ubicacion = data[0];
            })
            .catch(err => {console.error(err);});
          
        },
        actualizarUbicacion(){
            let datosEnviar={
                id: this.ubicacion.id,
                codigoAsignado: this.ubicacion.codigoAsignado,
                nombre: this.ubicacion.nombre,
                ubicacion: this.ubicacion.ubicacion,
                telefono: this.ubicacion.telefono
                }
            fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Ubicaciones.php?actualizar=1',{
                method: 'POST',
                body: JSON.stringify(datosEnviar)
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                window.location.href = '../ListaU';
            })
        }

    }      
}
</script>