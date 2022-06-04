<template>
    <div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createmodal" data-bs-backdrop="static">
            Add Person
        </button>

        <div class="modal fade" id="createmodal" refs="createmodal" style="display: none;" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Person Registration</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="FirstName">First Surname</label>
                                        <input type="text" id="FirstName" class="form-control" v-model="first_surname">
                                        <div v-if="errors">
                                            <div v-for="(error,e) in errors.first_surname" :key="e"><p class="text-danger">{{ error }}</p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="SecondName">Second Surname</label>
                                        <input type="text" id="SecondName" class="form-control" v-model="second_surname">
                                        <div v-if="errors">
                                            <div v-for="(error,e) in errors.second_surname" :key="e"><p class="text-danger">{{ error }}</p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="Name">Name</label>
                                        <input type="text" id="Name" class="form-control" v-model="name">
                                        <div v-if="errors">
                                            <div v-for="(error,e) in errors.name" :key="e"><p class="text-danger">{{ error }}</p></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="IDNumber">Id Number</label>
                                        <input type="text" id="IDNumber" class="form-control" v-model="id_number">
                                        <div v-if="errors">
                                            <div v-for="(error,e) in errors.id_number" :key="e"><p class="text-danger">{{ error }}</p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="DocumentType">Document Type</label>
                                        <select class="form-control" v-model="document_type">
                                            <option value="">Choose One</option>
                                            <option v-for="(document_type,dt) in document_types" :key="dt.id" :value="document_type.id">{{ document_type.document_type}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="clear">Close</button>
                            <button type="submit" class="btn btn-success" @click="store">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert'
    export default {
        data(){
            return {
                first_surname:'',
                second_surname:'',
                name:'',
                id_number:'',
                errors:{},
                error_message:'',
                document_types:[],
                document_type:'',
            }
        },
        mounted(){
            this.getData();
            Echo.channel('documenttyperegistration').listen('DocuemntTypeRegisteredEvent',(e) => {
                this.getData();
            });
        },
        methods:{
            store(){
                let formdata = new FormData
                formdata.append('first_surname',this.first_surname)
                formdata.append('second_surname',this.second_surname)
                formdata.append('name',this.name)
                formdata.append('id_number',this.id_number)
                formdata.append('document_type',this.document_type)
                axios.post('/people',formdata).then(response=>{
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
                this.$refs.createmodal.hide
                this.first_surname = ''
                this.second_surname = ''
                this.name = ''
                this.errors = {}
                this.error_message = ''
            },
            getData(){
                axios.get('/document_type').then(response=>{
                    this.document_types = response.data;
                })
            }
        }
    }
</script>
