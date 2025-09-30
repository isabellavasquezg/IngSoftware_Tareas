<template>
    <div class="container">
        <form v-on:submit.prevent="actualizarResponsable">
            <div class="mb-3">
            <label for="codigoAsignado" class="form-label">Código Asignado</label>
            <input type="text" required class="form-control" id="codigoAsignado" placeholder="Código asignado" v-model="responsable.codigoAsignado">
            </div>

            <div class="mb-3">
            <label for="documento" class="form-label">Documento</label>
            <input type="text" required class="form-control" id="documento" placeholder="Número de documento" v-model="responsable.documentoIdentidad">
            </div>

            <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" required class="form-control" id="nombre" placeholder="Nombre" v-model="responsable.nombre">
            </div>

            <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text"  required class="form-control" id="apellido" placeholder="Apellido" v-model="responsable.apellido">
            </div>

            <div class="mb-3">
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" required class="form-control" id="cargo" placeholder="Cargo" v-model="responsable.cargo">
            </div>

            <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" required class="form-control" id="telefono" placeholder="Ej: 999-999-999" v-model="responsable.telefono">
            </div>
            <div class="btn-group" role="group" aria-label="Grupo básico">
                <button type="submit" class="btn btn-success">Guardar</button>
                <router-link to="/listaR" class="btn btn-warning">Cancelar</router-link>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            responsable: {
            }
        }
    },
    created: function() {
        this.obtenerResponsable();
    },
    methods:{
        obtenerResponsable(){
            let idResponsable = this.$route.params.id;
            fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Responsables.php?consultar='+idResponsable)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                this.responsable = data[0];
            })
            .catch(err => {console.error(err);});
          
        },
        actualizarResponsable(){
            let datosEnviar={
                id: this.responsable.id,
                codigoAsignado: this.responsable.codigoAsignado,
                documentoIdentidad: this.responsable.documentoIdentidad,
                nombre: this.responsable.nombre,
                apellido: this.responsable.apellido,
                cargo: this.responsable.cargo,
                telefono: this.responsable.telefono
                }
            fetch('http://localhost/sgt/IngSoftware_Tareas/SISTEMA/APIS/Responsables.php?actualizar=1',{
                method: 'POST',
                body: JSON.stringify(datosEnviar)
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                window.location.href = '../listaR';
            })
        }

    }      
}
</script>