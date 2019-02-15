<template>
    <li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
        <a href="#" class="m-nav__link m-dropdown__toggle">
            <span class="m-topbar__userpic">
                <img :src="imagen" class="m--img-rounded m--marginless m--img-centered"/>
            </span>
            <span class="m-nav__link-icon m-topbar__usericon  m--hide">
                <span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
            </span>
            <span class="m-topbar__username m--hide">
                {{usu.name}}
            </span>
        </a>
        <div class="m-dropdown__wrapper">
            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
            <div class="m-dropdown__inner">
                <div class="m-dropdown__header m--align-center">
                    <div class="m-card-user m-card-user--skin-light">
                        <div class="m-card-user__details">
                            <span class="m-card-user__name m--font-weight-500">
                                {{usu.name}}
                            </span>
                            <a href="#email" class="m-card-user__email m--font-weight-300 m-link">
                                {{usu.email}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="m-dropdown__body">
                    <div class="m-dropdown__content">
                        <ul class="m-nav m-nav--skin-light">
                            <li class="m-nav__item">
                                <a :href="ru" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">
                                                Perfil
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="#soporte" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                    <span class="m-nav__link-text">
                                        Soporte
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__separator m-nav__separator--fit"></li>
                            <li class="m-nav__item">
                                <button v-on:click="loginOut" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                    Cerrar sesión
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        name: "perfil-usr",
        props:['usu','salir','ima','ru'],
        data: () => ({
            imagen:'',
        }),
        watch:{
            imagen:function(val){
                if(val==='' || val===null || val===undefined)
                    this.imagen=this.ima;
            }
        },
        methods:{
            loginOut:function(){
                axios.post(this.salir)
                    .then(response=>{
                        location.reload();
                    });
            }
        },
        mounted(){
            this.imagen=this.usu.avatar;
        }
    }
</script>

<style scoped>

</style>