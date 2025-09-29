<template>
    <div>Pagina Editar Ubicaciones</div>
    <div v-for="ubicacion in ubicaciones" :key="ubicacion.id">
        <p>{{ubicacion.id}}</p>
        <p>{{ubicacion.CodigoAsignado}}</p>
        <p>{{ubicacion.nombre}}</p>
        <p>{{ubicacion.ubicacion}}</p>
        <p>{{ubicacion.telefono}}</p>
    </div>  
</template>
<script>
export default {
    data(){
    },
    created(){
        this.constultarResponsables()
    },
    methods:{
        constultarResponsables(){
            fetch('http://localhost:3000/ubicaciones')
            .then(res => res.json())
            .then(data => {
                console.log(data)
                this.ubicaciones=[]
                if(typeof data[0].sucess === 'undefined'){
                    this.ubicaciones = data
                }
            })
            .catch(console.log)
        }
    }
}
</script>