<template>
    
        <input type="submit" 
        class="btn btn-danger d-block mb-2 w-100" 
        value="Eliminar ×" 
        v-on:click="eliminarReceta">               
    
</template>

<script>
export default {
    props:['recetaId'],
    
    methods: {
        eliminarReceta(){
            //console.log('diste click',this.recetaId);
             
            this.$swal({
                title: 'Desas eliminar esta receta?',
                text: "Una vez eliminada, no se puede recuperar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const params = {
                        id: this.recetaId
                    }
                    // Enviar la peticion al servidor
                    axios.post(`/recetas/${this.recetaId}`, {params, _method:'delete'})
                        .then(respuesta=>{
                            
                            this.$swal(
                                'Receta Eliminada!',
                                'Se eliminó la receta',
                                'success'
                                )
                                // Eliminar receta de DOM
                                //console.log(this.$el);
                                this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode)
                        })
                        .catch(error=>{
                            console.log(error)
                        })
                    
                }
            })
        }
    },
}
</script>