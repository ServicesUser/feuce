<template>
    <li class="m-nav__item m-topbar__quick-actions m-dropdown m-dropdown--skin-light m-dropdown--large m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"  data-dropdown-toggle="click">
        <a href="#" class="m-nav__link m-dropdown__toggle">
            <span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
            <span class="m-nav__link-icon">
                <span class="m-nav__link-icon-wrapper">
                    <i class="flaticon-network "></i>
                </span>
            </span>
        </a>
        <div class="m-dropdown__wrapper">
            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
            <div class="m-dropdown__inner">
                <div class="m-dropdown__header m--align-center">
                    <span class="m-dropdown__header-title">
                        {{org.org.ncomercial_or}}
                    </span>
                </div>
                <div class="m-dropdown__body">
                    <div class="m-dropdown__content">
                        <ul class="m-nav m-nav--skin-light">
                            <li class="m-nav__item" v-if="org.id_rol===2">
                                <a :href="rus" class="m-nav__link" >
                                    <i class="m-nav__link-icon flaticon-users"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">
                                                Sub-usuarios
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a :href="ro" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-interface-8"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">
                                                Perfil
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__separator m-nav__separator--fit"></li>
                            <li class="m-nav__item" v-if="org.org.adm_or===1">
                                <a :href="link+'/organizaciones'" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-cogwheel"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">
                                                Organizaciones
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item" v-if="org.org.adm_or===1">
                                <a :href="link+'/proyectos'" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-cogwheel"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">
                                                Proyectos
                                            </span>
                                        </span>
                                    </span>
                                </a>
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
        name: "perfil-org",
        props:['org','ro','rus'],
        computed:{
            link:function(){
                return window.location.origin;
            }
        }
    }
</script>

<style scoped>

</style>