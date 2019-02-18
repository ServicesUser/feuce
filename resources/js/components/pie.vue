<template>

</template>
<script>
    export default {
        name: "pie",
        props:['ue','faro','e','l'],
        methods:{
            grupofaro:function(){
                $('#grupoFaro').modal({show:true});
            },
            esquel:function(){
                $('#esquel').modal({show:true});
            },
            puce:function(){
                $('#puce').modal({show:true});
            },
            descargarManual:function(){
                window.open('http://repositorio.dgepuce.edu.ec/repository/unos/manualunos.pdf','_blank')
            }
        },
        mounted(){
            $(window).on('load', function() {
                $('body').removeClass('m-page--loading');
            });
        }
    }
</script>

<style scoped>

</style>