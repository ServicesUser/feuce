<template>
    <div class="row">
        <div class="col-lg-7">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-file"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Nuevas Elecciones
                            </h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--state" v-on:submit.prevent="validar('form-1')" data-vv-scope="form-1" v-if="paso===1">
                    <div class="m-portlet__body">
                        <div class="alert m-alert m-alert--default " :class="mensaje.clase" role="alert" v-html="mensaje.texto" ></div>
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group" :class="errors.has('form-1.título') ? 'has-danger' : ''">
                                <label class="form-control-label">Título:</label>
                                <textarea class="form-control m-input" v-validate="'required|max:500'" placeholder="Elecciones FEUCE 2019" name="título" v-model="registro.detalle"></textarea>
                                <span class="m-form__help">{{errors.first('form-1.título')}}</span>
                            </div>
                            <div class="form-group m-form__group" :class="errors.has('form-1.fecha') ? 'has-danger' : ''">
                                <label class="form-control-label">Fecha de elecciones:</label>
                                <datetime type="date" v-model="registro.fecha" input-class="form-control m-input" v-validate="'required'" placeholder="Elija una fecha"  name="fecha" :auto="true"  :phrases="{ok: 'Aceptar', cancel: 'Cancelar'}" format="cccc, d LLLL y" value-zone="UTC-5"></datetime>
                                <span class="m-form__help">{{errors.first('form-1.fecha')}}</span>
                            </div>
                            <div class="form-group m-form__group" :class="errors.has('form-1.inicio') ? 'has-danger' : ''">
                                <label class="form-control-label">Hora de inicio:</label>
                                <datetime type="time" v-model="registro.inicio" input-class="form-control m-input" v-validate="'required'" placeholder="Elija una hora"  name="inicio" :auto="true"  :phrases="{ok: 'Aceptar', cancel: 'Cancelar'}" format="T" value-zone="UTC-5"></datetime>
                                <span class="m-form__help">{{errors.first('form-1.inicio')}}</span>
                            </div>
                            <div class="form-group m-form__group" :class="errors.has('form-1.fin') ? 'has-danger' : ''">
                                <label class="form-control-label">Hora de finalización:</label>
                                <datetime type="time" v-model="registro.fin" input-class="form-control m-input" v-validate="'required'" placeholder="Elija una hora"  name="fin" :auto="true"  :phrases="{ok: 'Aceptar', cancel: 'Cancelar'}" format="T" value-zone="UTC-5"></datetime>
                                <span class="m-form__help">{{errors.first('form-1.fin')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <button type="submit" class="btn btn-primary">Siguiente</button>
                        </div>
                    </div>
                </form>
                <form class="m-form m-form--state" v-on:submit.prevent="validar('form-2')" data-vv-scope="form-2" v-if="paso===2">
                    <div class="m-portlet__body">
                        <div class="alert m-alert m-alert--default " :class="mensaje.clase" role="alert" v-html="mensaje.texto" ></div>
                        <div class="m-form__section m-form__section--first">
                            <button type="button" class="btn btn-primary" v-on:click="agregar">Agregar Candidato</button>
                            <button type="button" class="btn btn-outline-primary"  data-toggle="modal" data-target="#newMov">Agregar Movimiento</button>
                            <button type="button" class="btn btn-outline-primary"  data-toggle="modal" data-target="#newDig">Agregar Dignidad</button>
                            <hr>
                            <div class="card mt-3" v-for="(item,index) in registro.miembros" :key="index" :class="index % 2 ===0 ? 'bg-light' : '' ">
                                <div class="card-header">
                                    Miembro {{index+1}} <button class=" btn btn-sm btn-outline-danger" v-if="registro.miembros.length>1" type="button" v-on:click="quitar(index)">Eliminar</button>
                                </div>
                                <div class="card-body">
                                    <div class="form-group m-form__group" :class="errors.has('form-2.'+'dignidad'+(index+1)) ? 'has-danger' : ''" >
                                        <label class="form-control-label" >Dignidad:</label>
                                        <select class="form-control m-input" :name="'dignidad'+(index+1)" v-model="item.dignidad" v-validate="'required'">
                                            <option :value="item2" v-for="item2 in dignidades">{{item2.name}}{{item2.name2 ? '/' :''}}{{item2.name2}}</option>
                                        </select>
                                        <span class="m-form__help">{{errors.first('form-2.'+'dignidad'+(index+1))}}</span>
                                    </div>
                                    <div class="form-group m-form__group" :class="errors.has('form-2.'+'movimiento'+(index+1)) ? 'has-danger' : ''" >
                                        <label class="form-control-label" >Movimiento:</label>
                                        <select class="form-control m-input" :name="'movimiento'+(index+1)" v-model="item.movimiento" v-validate="'required'">
                                            <option :value="item3.id" v-for="item3 in movimientos">{{item3.name}}</option>
                                        </select>
                                        <span class="m-form__help">{{errors.first('form-2.'+'movimiento'+(index+1))}}</span>
                                    </div>
                                    <div class="form-group m-form__group" :class="errors.has('form-2.'+'nombre'+(index+1)) ? 'has-danger' : ''" >
                                        <label class="form-control-label">Nombre {{item.dignidad.name}}</label>
                                        <input type="text" class="form-control m-input" :name="'nombre'+(index+1)" :placeholder="'Nombre miembro'+(index+1)" v-model="item.nombre" v-validate="'required'"/>
                                        <span class="m-form__help">{{errors.first('form-2.'+'nombre'+(index+1))}}</span>
                                    </div>
                                    <div class="form-group m-form__group" :class="errors.has('form-2.'+'foto'+(index+1)) ? 'has-danger' : ''" >
                                        <label class="form-control-label" >Foto {{item.dignidad.name}}:</label>
                                        <div class="">
                                            <input type="file" class="form-control-file" accept="image/*" :name="'foto'+(index+1)" v-on:change="previewFiles($event,item)"  v-validate="'required|image'" data-vv-as="image">
                                            <div class="">
                                                <img :src="item.foto" class="img-responsive" height="70">
                                            </div>
                                        </div>
                                        <span class="m-form__help">{{errors.first('form-2.'+'foto'+(index+1))}}</span>
                                    </div>
                                    <div v-if="item.dignidad.name2">
                                        <hr>
                                        <div class="form-group m-form__group" :class="errors.has('form-2.'+item.dignidad.name2+(index+1)) ? 'has-danger' : ''" >
                                            <label class="form-control-label">Nombre {{item.dignidad.name2}}</label>
                                            <input type="text" class="form-control m-input" :name="item.dignidad.name2+(index+1)" :placeholder="'Nombre '+item.dignidad.name2+(index+1)" v-model="item.nombre2" v-validate="'required'"/>
                                            <span class="m-form__help">{{errors.first('form-2.'+item.dignidad.name2+(index+1))}}</span>
                                        </div>
                                        <div class="form-group m-form__group" :class="errors.has('form-2.'+'foto2'+(index+1)) ? 'has-danger' : ''" >
                                            <label class="form-control-label" >Foto {{item.dignidad.name2}}:</label>
                                            <div class="">
                                                <input type="file" class="form-control-file" accept="image/*" :name="'foto'+(index+1)" v-on:change="previewFiles2($event,item)"  v-validate="'required|image'" data-vv-as="image">
                                                <div class="">
                                                    <img :src="item.foto2" class="img-responsive" height="70">
                                                </div>
                                            </div>
                                            <span class="m-form__help">{{errors.first('form-2.'+'foto'+(index+1))}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <button type="button" class="btn btn-danger" v-on:click="paso--">Atrás</button>
                            <button type="submit" class="btn btn-primary">Siguiente</button>
                        </div>
                    </div>
                </form>
                <form class="m-form m-form--state" v-on:submit.prevent="validar('form-3')" data-vv-scope="form-3" v-if="paso===3">
                    <div class="m-portlet__body">
                        <div class="alert m-alert m-alert--default " :class="mensaje.clase" role="alert" v-html="mensaje.texto" ></div>
                        <div class="m-form__section m-form__section--first">
                            <vue-dropzone ref="myVueDropzone" id="dropzone" class="m-dropzone dropzone m-dropzone--primary dz-clickable" v-model="registro.excel"  :options="dropzoneOptions" @vdropzone-error="comprobarArchivo"  @vdropzone-success="uploadDone" name="excel" v-validate="'required'" ></vue-dropzone>
                            <span class="m-form__help">{{errors.first('form-e.excel')}}</span>
                        </div>
                        <a class="text-muted" data-toggle="tooltip" data-html="true" data-placement="top" :title="imagen" id="exa">
                            Ejemplo <i class="fa fa-question-circle"></i>
                        </a>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <button type="button" class="btn btn-danger" v-on:click="paso--">Atrás</button>
                            <button type="submit" class="btn btn-success">Finalizar</button>
                        </div>
                    </div>
                </form>
                <div class="m-form m-form--state" v-if="paso===4">
                    <div class="m-portlet__body">
                        <br><br><br><br>
                        <div class="text-center">
                            Cargando
                        </div>
                        <br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="modal fade" id="newMov">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nuevo Movimiento</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form class="m-form" v-on:submit.prevent="nuevoMov" data-vv-scope="newMov">
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row" :class="errors.has('newMov.nombre') ? 'has-danger' : ''">
                                        <label class="col-form-label col-lg-3">Nombre*</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control m-input" name="nombre" v-model="movimiento.name" v-validate="'required'">
                                            <div class="form-control-feedback">{{errors.first('newMov.nombre')}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" :class="errors.has('newMov.logo') ? 'has-danger' : ''">
                                        <label class="col-form-label col-lg-3">Logo*</label>
                                        <div class="col-lg-9">
                                            <input type="file" name="logo" v-validate="'required|image'" accept="image/*" v-on:change="previewFiles($event,movimiento)" data-vv-as="image">
                                            <img :src="movimiento.foto" class="img-responsive" height="70">
                                            <div class="form-control-feedback">{{errors.first('newMov.logo')}}</div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" v-on:click="nuevoMov">Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="newDig">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nueva Dignidad</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form class="m-form" v-on:submit.prevent="nuevaDig" data-vv-scope="newDig">
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row" :class="errors.has('newDig.título') ? 'has-danger' : ''">
                                        <label class="col-form-label col-lg-3">1er Título*</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control m-input" name="título" placeholder="Vocal" v-model="dignidad.name" v-validate="'required'">
                                            <div class="form-control-feedback">{{errors.first('newDig.título')}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" :class="errors.has('newDig.título2') ? 'has-danger' : ''">
                                        <label class="col-form-label col-lg-3">2do Título</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control m-input" name="título2" placeholder="Vocal Suplente" v-model="dignidad.name2" >
                                            <div class="form-control-feedback">{{errors.first('newDig.título2')}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" :class="errors.has('newDig.rango') ? 'has-danger' : ''">
                                        <label class="col-form-label col-lg-3">Rango*</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control m-input" name="rango" placeholder="5" v-validate="'required|integer'" v-model="dignidad.order">
                                            <div class="form-control-feedback">{{errors.first('newDig.rango')}}</div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" v-on:click="nuevaDig">Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Elecciones Creadas
                            </h3>
                        </div>
                    </div>
                </div>
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
    import Datetime from 'vue-datetime';
    import vue2Dropzone from 'vue2-dropzone';
    import { Settings } from 'luxon';
    Settings.defaultLocale = 'es';
    Vue.use(Datetime);
    Validator.localize('es',es);
    Vue.use(VeeValidate);
    export default {
        name: "campanas",
        data:()=>({
            columns: [
                {
                    label: 'Detalle',
                    field: 'detalle_ca',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Filtro por siglas',
                    },
                },
                {
                    label: 'Estado',
                    field: 'estado_ca',
                },
                {
                    label: 'Empieza',
                    field: 'desde_ca',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Filtro por fecha',
                    },
                },
                {
                    label: 'Finaliza',
                    field: 'vence_ca',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Filtro por fecha',
                    },
                },
            ],
            rows: [],
            dropzoneOptions: {
                url: location.origin+'/app/archivo',
                headers: { "X-CSRF-TOKEN": window.axios.defaults.headers.common['X-CSRF-TOKEN']},
                paramName: 'excel',
                acceptedFiles:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                maxFiles:1,
                dictDefaultMessage: 'Arrastre y Suelte aquí un Archivo Excel',
            },
            paso:1,
            mensaje:{
                texto:'Se enviará un email a cada persona que conste en el padrón electoral con las instrucciones del proceso.',
                clase:'',
            },
            registro:{
                detalle:'',
                miembros:[],
                excel:''
            },

            movimientos:[],
            dignidades:[],

            dignidad:{
                name:'',
                name2:'',
                order:'',
            },
            movimiento:{
                name:'',
                foto:'',
            },
        }),
        components: {
            VueGoodTable,
            vueDropzone: vue2Dropzone
        },
        watch:{
          paso:function(val){
              if(val===1)
                  this.mensaje={
                      texto:'Se enviará un email a cada persona que conste en el padrón electoral con las instrucciones del proceso.',
                          clase:'',
                  };
              if(val===2)
                  this.mensaje={
                      texto:'Agregue cada uno de los candidatos con su movimiento y una foto.',
                      clase:'',
                  };
              if(val===3)
                  this.mensaje={
                      texto:'Suba un archivo Excel con solo las cédulas de todas las personas que deben sufragar.',
                      clase:'',
                  };

          }
        },
        computed:{
            imagen:function(){
                let a=location.origin+'/images/ejemplo.PNG'
                return `<img src=${a} class="img-responsive exa" />`;
            }
        },
        methods:{
            agregar:function(){
                let a = new Object();
                a.foto=null;
                a.foto2=null;
                a.dignidad={};
                this.registro.miembros.push(a);
            },
            quitar:function(num){
                this.registro.miembros.splice(num, 1);
            },
            validar:function(scope){
                let vm=this;
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        vm.paso++;
                        if(vm.paso===4){
                            vm.nuevo();
                        }
                    }else{
                        vm.mensaje={
                            texto:"Complete el formulario.",
                            clase:'alert-warning',
                        };
                    }
                });
            },
            comprobarArchivo:function(file){
                this.registro.excel=null;
                this.$refs.myVueDropzone.removeAllFiles();
                iziToast.error({
                    title: 'Error',
                    message: file.name+" no es un Excel válido",
                });
            },
            uploadDone:function(file, response){
                if(response.val){
                    this.registro.excel={file:response.archivo,cantidad:response.resultado};
                    iziToast.success({
                        title: 'Éxito',
                        message: response.mensaje,
                    });
                }else{
                    this.$refs.myVueDropzone.removeAllFiles();
                    iziToast.error({
                        title: 'Error',
                        message: "Vuelva a intentar",
                    });
                }
            },
            nuevaDig:function(){
                let vm=this;
                this.$validator.validateAll('newDig').then((result) => {
                    if (result) {
                        axios.post(location.origin+'/api/dig',
                            vm.dignidad)
                            .then(response=>{
                                if(response.data.val){
                                    iziToast.success({
                                        title: 'Éxito',
                                        message: response.data.mensaje,
                                    });
                                    vm.cargarDig();
                                    $('#newDig').modal('hide');
                                    vm.dignidad={
                                        name:'',
                                        order:'',
                                    };
                                }else{
                                    iziToast.error({
                                        title: 'Error',
                                        message: response.data.mensaje,
                                    });
                                }
                            })
                            .catch((response) => {
                                iziToast.warning({
                                    title: 'Error',
                                    message: 'Ha ocurrido un error vuelva a intentar.',
                                });
                            });
                    }else{
                        iziToast.warning({
                            title: 'Error',
                            message: "Complete el formulario para agregar una Dignidad a la Lista",
                        });
                    }
                });
            },
            nuevoMov:function(){
                let vm=this;
                this.$validator.validateAll('newMov').then((result) => {
                    if (result) {
                        axios.post(location.origin+'/api/mov',
                            vm.movimiento)
                            .then(response=>{
                                if(response.data.val){
                                    iziToast.success({
                                        title: 'Éxito',
                                        message: response.data.mensaje,
                                    });
                                    vm.cargarMov();
                                    $('#newMov').modal('hide');
                                    vm.movimiento={
                                        name:'',
                                        foto:'',
                                    };
                                }else{
                                    iziToast.error({
                                        title: 'Error',
                                        message: response.data.mensaje,
                                    });
                                }
                            })
                            .catch((response) => {
                                iziToast.warning({
                                    title: 'Error',
                                    message: 'Ha ocurrido un error vuelva a intentar.',
                                });
                            });
                    }else{
                        iziToast.warning({
                            title: 'Error',
                            message: "Complete el formulario para agregar un Movimiento a la Lista",
                        });
                    }
                });
            },
            previewFiles:function(e,item) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                let reader = new FileReader();
                reader.onload = (e) => {
                    item.foto = e.target.result;
                };
                reader.readAsDataURL(files[0]);
            },
            previewFiles2:function(e,item) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                let reader = new FileReader();
                reader.onload = (e) => {
                    item.foto2 = e.target.result;
                };
                reader.readAsDataURL(files[0]);
            },
            nuevo:function(){
                let vm=this;
                axios.post(location.origin+location.pathname,
                vm.registro).then((response)=>{

                }).catch((error) => {
                    iziToast.error({
                        title: 'Error',
                        message: "Vuelva a intentar",
                    });
                });
            },
            cargar:function(){
                let vm=this;
                axios.options(location.origin+location.pathname)
                    .then((response) => {
                        vm.rows=response.data;
                    });
            },
            cargarMov:function(){
                let vm=this;
                axios.get(location.origin+'/api/mov')
                    .then((response) => {
                        vm.movimientos=response.data;
                    });
            },
            cargarDig:function(){
                let vm=this;
                axios.get(location.origin+'/api/dig')
                    .then((response) => {
                        vm.dignidades=response.data;
                    });
            }
        },
        mounted(){
            this.$validator.locale = 'es';
            this.cargar();
            this.cargarMov();
            this.cargarDig();
            this.agregar();
        },
        updated(){
            $('[data-toggle="tooltip"]').tooltip({
                animated: 'fade',
                html: true
            });
        }
    }
</script>

<style scoped>
    .exa{
        max-height: 600px;
    }
</style>