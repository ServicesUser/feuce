<template>
    <div class="row">
        <div class="col-lg-5">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-file"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Nueva Asociación de Estudiantes
                            </h3>
                        </div>
                    </div>
                </div>
                <form class="m-form" v-on:submit.prevent="nuevo">
                    <div class="m-portlet__body">
                        <div class="alert m-alert m-alert--default " :class="mensaje.clase" role="alert" v-html="mensaje.texto" ></div>
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group">
                                <label>Siglas:</label>
                                <input type="text" class="form-control m-input" v-validate="'required|alpha_dash|max:50'" placeholder="AEI-PUCE" name="siglas" v-model="registro.siglas">
                                <span class="m-form__help">{{errors.first('siglas')}}</span>
                            </div>
                            <div class="form-group m-form__group">
                                <label>Detalle:</label>
                                <input type="text" class="form-control m-input" v-validate="'required|max:100'" placeholder="Asociación de Estudiantes de Ingeniería PUCE" name="detalle" v-model="registro.detalle">
                                <span class="m-form__help">{{errors.first('detalle')}}</span>
                            </div>
                            <div class="form-group m-form__group">
                                <label>Email:</label>
                                <input type="email" class="form-control m-input" v-validate="'required|email'" placeholder="jhondoe@hotmail.com" name="email" v-model="registro.email">
                                <span class="m-form__help">{{errors.first('email')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Registrados
                            </h3>
                        </div>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="m-form">
                    <div class="m-portlet__body">
                        <vue-good-table
                                styleClass="table table-bordered m-table m-table--border-brand m-table--head-bg-brand table-hover"
                                :columns="columns"
                                :rows="rows"
                                :pagination-options="{
                                    enabled: true,
                                    mode: 'registros',
                                    perPage: 10,
                                    position: 'arriba',
                                    dropdownAllowAll: false,
                                    nextLabel: 'siguiente',
                                    prevLabel: 'anterior',
                                    rowsPerPageLabel: 'Registros por página',
                                    ofLabel: 'de',
                                    pageLabel: 'página',
                                    allLabel: 'Todos',
                                  }"
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { VueGoodTable } from 'vue-good-table';
    import VeeValidate,{Validator} from 'vee-validate';
    import es from 'vee-validate/dist/locale/es';
    Validator.localize('es',es);
    Vue.use(VeeValidate);
    export default {
        name: "asociaciones",
        data:()=>({
            columns: [
                {
                    label: 'Siglas',
                    field: 'name',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Filtro por siglas',
                    },
                },
                {
                    label: 'Detalle',
                    field: 'details',
                },
                {
                    label: 'Email',
                    field: 'email',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Filtro por email',
                    },
                },
                {
                    label: 'Validado',
                    field: 'email_verified_at',
                    //type: 'date',
                    dateInputFormat: 'YYYY-MM-DD H'
                },
            ],
            rows: [],
            mensaje:{
              texto:'Se enviará un email con la contraseña de la cuenta.',
              clase:'',
            },
            registro:{
                email:'',
                siglas:'',
                detalle:'',
            }
        }),
        components: {
            VueGoodTable,
        },
        methods:{
            nuevo:function(){
                let vm=this;
                this.$validator.validate().then(result => {
                    if (result) {
                        axios.post(location.origin+location.pathname,
                            vm.registro)
                            .then((response) => {
                                if(response.data.val){
                                    vm.cargar();
                                    vm.mensaje={
                                        texto:'Se enviará un email con la contraseña de la cuenta.',
                                            clase:'',
                                    };
                                    vm.registro={
                                        email:'',
                                        siglas:'',
                                        detalle:'',
                                    }
                                }else{
                                    vm.mensaje={
                                        texto:response.data.mensaje,
                                        clase:'alert-danger',
                                    };
                                }
                            }).catch((error) => {
                                vm.mensaje={
                                    texto:"Ha ocurrido un error refresque la página y vuelva a intentar.",
                                    clase:'alert-danger',
                                };
                        });
                    }else{
                        vm.mensaje={
                            texto:"Complete el formulario.",
                            clase:'alert-warning',
                        };
                    }
                });

            },
            cargar:function(){
                let vm=this;
                axios.options(location.origin+location.pathname)
                    .then((response) => {
                        vm.rows=response.data;
                    });
            }
        },
        mounted(){
            this.$validator.locale = 'es';
            this.cargar();
        }

    }
</script>

<style scoped>

</style>