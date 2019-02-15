<template>
    <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1" v-if="notificaciones.length>0">
        <a href="#" class="m-nav__link m-dropdown__toggle">
            <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger m-animate-blink"></span>
            <span class="m-nav__link-icon m-animate-shake">
                <span class="m-nav__link-icon-wrapper">
                    <i class="flaticon-alarm"></i>
                </span>
            </span>
        </a>
        <div class="m-dropdown__wrapper">
            <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
            <div class="m-dropdown__inner">
                <div class="m-dropdown__header m--align-center" v-if="notificaciones.length>1">
                    <span class="m-dropdown__header-title">
                        {{notificaciones.length}} notificaciones
                    </span>
                </div>
                <div class="m-dropdown__body">
                    <div class="m-dropdown__content">
                        <div class="m-scrollable" :m-scrollabledata-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                            <div class="m-list-timeline m-list-timeline--skin-light">
                                <div class="m-list-timeline__items">
                                    <div class="m-list-timeline__item" v-for="item in notificaciones">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                        <a :href="item.url" class="m-list-timeline__text">
                                            {{item.mensaje}}
                                        </a>
                                        <span class="m-list-timeline__time">
                                            {{item.fecha}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        name: "notificaciones",
        data:()=>({
            notificaciones:[],
            echo:null,
        }),
        props:['usu'],
        methods:{
            cargar:function(){
                axios.options(window.location.origin+'/app/notificaciones')
                    .then((response) => {
                        if(response.data){
                            this.notificaciones=response.data;
                        }
                    });
            },
            fechaHum:function(fecha){

            }
        },
        created(){
            this.cargar();
        },
        mounted(){
            let usuario=this.usu.code;
            Echo.private('usuario.'+usuario)
                .notification((e) => {
                    toastr.info(e.mensaje,'',{onclick: function() {
                        if(e.url!==null)
                            window.location.href=e.url;
                    }});
                    this.cargar();
                });
        }
    }
</script>

<style scoped>

</style>