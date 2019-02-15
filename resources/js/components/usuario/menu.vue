<template>
    <div class="m-header__bottom">
        <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
                    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light" id="m_aside_header_menu_mobile_close_btn">
                        <i class="la la-close"></i>
                    </button>
                    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light">
                        <ul class="m-menu__nav  m-menu__nav--submenu-arrow">
                            <li class="m-menu__item " aria-haspopup="true" v-for="(item,index) in menu" m-menu-submenu-toggle="hover" :key="index" :class="lvl1(item)">
                                <a :href="item.url" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">{{item.name}}</span>
                                    <i class="m-menu__hor-arrow la la-angle-down" v-if="item.items"></i>
                                    <i class="m-menu__ver-arrow la la-angle-right" v-if="item.items"></i>
                                </a>
                                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left" v-if="item.items" >
                                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item " aria-haspopup="true" v-for="item2 in item.items" :class="item2.url===actual ? 'm-menu__item--active' : ''">
                                            <a :href="item2.url" class="m-menu__link">
                                                <i class="m-menu__link-icon " :class="item2.icon ? item2.icon : 'la la-minus'"></i>
                                                <span class="m-menu__link-title">
                                                    <span class="m-menu__link-wrap">
                                                        <span class="m-menu__link-text">{{item2.name}}</span>
                                                        <span class="m-menu__link-badge" v-if="item2.label">
                                                            <span class="m-badge m-badge--de">{{item2.label}}</span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {Bus} from '../../app';
    export default {
        name: "menu-us",
        data: () => ({
            menu:[],
        }),
        mounted(){
            Bus.$on('actualizar-menu',function(menu){
                this.menu=menu;
            }.bind(this));
            this.cargar();
            console.log('%c Developed by GoldenBytes ', 'background: red; color: white');
        },
        computed:{
            actual:function(){
                return window.location.href;
            }
        },
        methods:{
            lvl1:function(item){
                let actual  =   location.origin+location.pathname;
                if(item.url===actual)
                    return "m-menu__item--active ";
                let a   =   '';
                if(item.items){
                    item.items.forEach(function(element) {
                        if(element.url===actual)
                            a="m-menu__item--active ";
                    });
                    a+="m-menu__item--submenu m-menu__item--rel";
                }
                return a;
            },
            comprobar:function(pedaso=' '){
                let actual  =   window.location.href;
                let val     =   false;
                if(actual.indexOf(pedaso)>=0)
                    val=true;
                return val;
            },
            home:function(pedaso){
                let url =   window.location.href;
                return url === pedaso || url.indexOf('organizacion') >= 0 || url.indexOf('proyectos') >= 0;
            },
            cargar:function(){
                axios({
                    method: 'GET',
                    url: location.origin+'/app',
                }).then((response) => {
                    this.menu=response.data;
                    //Bus.$emit('set-user',response.data.user);
                    //Bus.$emit('set-notificaciones',response.data.notifications);
                    //Bus.$emit('set-user-img',response.data.user);
                }).catch((error) => {
                    this.cargar();
                });
            },
        }
    }
</script>

<style scoped>
</style>