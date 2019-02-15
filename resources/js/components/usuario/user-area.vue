<template>
    <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
        <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
            <div class="m-stack__item m-topbar__nav-wrapper">
                <ul class="m-topbar__nav m-nav m-nav--inline">
                    <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                        <a href="#" class="m-nav__link m-dropdown__toggle">
                            <span class="m-topbar__welcome">Hello,&nbsp;</span>
                            <span class="m-topbar__username">Nick</span>
                        </a>
                        <div class="m-dropdown__wrapper">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__header m--align-center" style="background-color:gray; background-size: cover;">
                                    <div class="m-card-user m-card-user--skin-dark">
                                        <div class="m-card-user__details">
                                            <span class="m-card-user__name m--font-weight-500">Mark Andre</span>
                                            <a href="" class="m-card-user__email m--font-weight-300 m-link">mark.andre@gmail.com</a>
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
                                                <a href="snippets/pages/user/login-1.html" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Cerrar Sesión</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <notificaciones></notificaciones>
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
            'perfil-org':perfil,
            'perfil-usr':usuario,
        },
        data: () => ({
            info:[],
            menu:[],
            todo:[],
            cargado:false
        }),
        props: ['url','o','u','us'],
        computed:{
            fotoPerfil:function(){
                if(this.info.avatar===null) {
                    Bus.$emit('actualizar-foto',this.todo.img);
                    return this.todo.img;
                }else {
                    Bus.$emit('actualizar-foto',this.info.avatar);
                    return this.info.avatar;
                }
            }
        },
        methods:{
            cargar:function(){
                this.cargado=false;
                axios.get(this.url)
                    .then(response=>{
                        this.info=response.data.info;
                        this.menu=response.data.rutas;
                        this.todo=response.data;
                        Bus.$emit('actualizar-menu',response.data.rutas);
                        Bus.$emit('actualizar-basica',response.data.info);
                        this.cargado=true;
                    });
            }
        },
        created(){
            this.cargar();
        },
        mounted(){
            Bus.$on('actualizar-info',function(){
                this.cargar();
            }.bind(this));
        }
    }
</script>

<style>
    .m-nav__link-icon-wrapper{
        background-color: #00b3c2;
    }
</style>