<template>
    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createmodal">
            Add Item
        </button>

        <div class="modal fade" id="createmodal" data-bs-backdrop="static" data-bs-keyboard="false" style="display: none;" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Item Registration</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Code">Code</label>
                                        <input type="text" id="Code" class="form-control" v-model="code">
                                        <div v-if="errors">
                                            <div v-for="(error,e) in errors.code" :key="e"><p class="text-danger">{{ error }}</p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Item">Item</label>
                                        <input type="text" id="Item" class="form-control" v-model="item">
                                        <div v-if="errors">
                                            <div v-for="(error,e) in errors.item" :key="e"><p class="text-danger">{{ error }}</p></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Brand">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customBrandsSwitch1" v-model="brandtoggle">
                                                <label class="custom-control-label" for="customBrandsSwitch1">Brands</label>
                                            </div>
                                        </label>
                                        <select class="form-control" v-model="brand"  v-if="brandtoggle">
                                            <option value="">Choose One Brand</option>
                                            <option v-for="(brand,b) in brands" :key="b.id" :value="brand.id">{{ brand.brand}}</option>
                                        </select>
                                        <select class="form-control" v-else disabled>
                                            <option value="">Choose One Brand</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Design">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customDesignSwitch1" v-model="designtoggle">
                                                <label class="custom-control-label" for="customDesignSwitch1">Designs</label>
                                            </div>
                                        </label>
                                        <select class="form-control" v-model="design" v-if="designtoggle">
                                            <option value="">Choose One Design</option>
                                            <option v-for="(design,d) in designs" :key="d.id" :value="design.id">{{ design.design}}</option>
                                        </select>
                                        <select class="form-control" v-else disabled>
                                            <option value="">Choose One Design</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <StreamBarcodeReader @decode="onDecode" @loaded="onLoaded"></StreamBarcodeReader>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" @click="store">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { StreamBarcodeReader } from "vue-barcode-reader";
    import swal from 'sweetalert'
    export default {
        components:{
            StreamBarcodeReader,
        },
        props:['item_id'],
        data(){
            return {
                code:'',
                item:'',
                errors:{},
                error_message:'',
                brands:[],
                designs:[],
                brand:'',
                design:'',
                designtoggle:true,
                brandtoggle:true,

            }
        },
        mounted(){
            this.getData();
            Echo.channel('degisnregistered').listen('DesignRegisteredEvent',(e) => {
                this.getData();
            });
            Echo.channel('brandregistered').listen('BrandRegisteredEvent',(e) => {
                this.getData();
            });
        },
        methods:{
            getData(){
                axios.get('/brand').then(response=>{this.brands = response.data});
                axios.get('/design').then(response=>{this.designs = response.data});
            },
            store(){
                let formdata = new FormData
                formdata.append('code',this.code)
                formdata.append('item',this.item)
                if(this.brandtoggle)
                {
                    formdata.append('brand',this.brand)
                }
                if(this.designtoggle)
                {
                    formdata.append('design',this.design)
                }
                axios.post('/item',formdata).then(response=>{
                    $('#createmodal').modal('hide');
                     swal({
                        icon: "success",
                        title: response.data.message,
                    });
                    this.clear()
                }).catch(error=>{
                    this.errors = error.response.data.errors
                    this.error_message = error.response.data.message
                })
            },
            clear(){
                this.code = ''
                this.item = ''
                this.errors = {}
                this.error_message = ''
                this.brand = ''
                this.design = ''
            },
            onDecode(result){
                console.log(result)
            },
            onLoaded() {
                console.log("load");
            },
        }
    }
</script>
