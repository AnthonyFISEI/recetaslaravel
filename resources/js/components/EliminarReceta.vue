<template>
     <input type="submit" class="btn btn-danger mr-1 d-block w-100 mb-2" value="Eliminar ×"
     @click="eliminarReceta">
</template>

<script>
export default {
    props: ['recetaId'],
    // mounted(){
    //     console.log('receta actual',this.recetaId);
    // },
    methods:{
        eliminarReceta(){
            // console.log('diste click', this.recetaId);
            this.$swal({
            title: '¿Deseas eliminar esta receta?',
            text: "Una vez eliminada, no se puede recuperar",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
            }).then((result) => {
            if (result.isConfirmed) {

                //Enviar la peticion al servidor
                
                // Axios
                // parametros
                const params ={
                    id: this.recetaId
                }
                axios.post(`/recetas/${this.recetaId}`,{params,_method: 'delete'})
                    .then(respuesta=>{
                        // console.log(respuesta)  
                        this.$swal(
                        'Receta Eliminada',
                        'Se eliminó la receta',
                        'success'
                        );                
                        // Eliminar receta del DOm
                        this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                    })
                    .catch(error=>{
                        console.log(error)
                    });

  
            }
            })
        }
    }
}
</script>