<template>
    <div class="m-nav-grid">
        <div class="m-nav-grid__row" v-for="grup in grupo"                                                                                                  >
            <a :href="item.url" class="m-nav-grid__item" v-for="item in grup">
                <i class="m-nav-grid__icon " :class="item.icon ? item.icon : 'fa fa-check'"></i>
                <span class="m-nav-grid__text">{{item.name}}</span>
            </a>
        </div>
    </div>
</template>

<script>
    import {Bus} from '../../../app';
    export default {
        name: "menu-evoto",
        data: () => ({
            opciones:[],
            grupo:[],
        }),
        watch:{

        },
        methods:{
            chunk:function(arr, size) {
                let newArr = [];
                for (let i=0; i<arr.length; i+=size) {
                    newArr.push(arr.slice(i, i+size));
                }
                this.grupo  = newArr;
            }
        },
        mounted(){
            let mv = this;
            Bus.$on('actualizar-info',function(consulta){
                this.opciones=consulta.menu[1].items;
                mv.chunk(this.opciones, 3);
            }.bind(this));
        }
    }
</script>

<style scoped>

</style>