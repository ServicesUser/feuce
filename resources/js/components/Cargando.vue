<template>

</template>
<script>
    export default {
        name: "cargando",
        mounted(){
            $(window).on('load', function() {
                $('body').removeClass('m-page--loading');
            });
        }
    }
</script>