<template >
    <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav" v-if="cargado">
        <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
            <div class="m-stack__item m-topbar__nav-wrapper">
                <ul class="m-topbar__nav m-nav m-nav--inline">
                    <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                        <a href="#" class="m-nav__link m-dropdown__toggle">
                            <span class="m-topbar__welcome">Hola,&nbsp;</span>
                            <span class="m-topbar__username">{{nomCorto}}</span>
                        </a>
                        <div class="m-dropdown__wrapper">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__header m--align-center" style="background-color:gray; background-size: cover;">
                                    <div class="m-card-user m-card-user--skin-dark">
                                        <div class="m-card-user__details">
                                            <span class="m-card-user__name m--font-weight-500">{{info.name}}</span>
                                            <a href="" class="m-card-user__email m--font-weight-300 m-link">{{info.email}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-dropdown__body">
                                    <div class="m-dropdown__content">
                                        <ul class="m-nav m-nav--skin-light">
                                            <li class="m-nav__section m--hide">
                                                <span class="m-nav__section-text">Section</span>
                                            </li>
                                            <li class="m-nav__separator m-nav__separator--fit">
                                            </li>
                                            <li class="m-nav__item">
                                                <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" v-on:click="cerrar">Cerrar Sesión</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <notificaciones :lista="notificaciones" :usu="info"></notificaciones>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import notificaciones from './notificaciones';
    import perfil from './perfil-org';
    import usuario from './perfil-usr';
    import {Bus} from '../../app';
    export default {
        name: "user-area",
        components: {
            'notificaciones':notificaciones,
        },
        data: () => ({
            info:{},
            notificaciones:[],
            cargado:false
        }),
        computed:{
            nomCorto:function(){
                let a = this.info.name;
                let b = a.split(" ");
                return b[0];
            }

        },
        methods:{
            cerrar:function(){
                axios.post(location.origin+'/logout')
                    .then(response=>{
                        location.reload();
                    });
            }
        },
        mounted(){
            Bus.$on('actualizar-info',function(consulta){
                this.info=consulta.user;
                this.notificaciones=consulta.notifications;
                this.cargado=true;
            }.bind(this));
        }
    }
</script>

<style>
    .m-topbar .m-topbar__nav.m-nav > .m-nav__item.m-topbar__user-profile.m-topbar__user-profile--img.m-dropdown--arrow .m-dropdown__arrow{
        color:#808080;
    }
</style>