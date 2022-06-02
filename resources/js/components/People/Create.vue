<template>
    <div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default" data-bs-backdrop="static">
            Add Person
        </button>

        <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true" >
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
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="clear">Close</button>
                            <button type="submit" class="btn btn-success" @click="store">Submit</button>
                        </div>
                        <div v-if="error_message">
                            {{ showAlert() }}
                            <div><p class="text-danger">{{ error_message }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                first_surname:'',
                second_surname:'',
                name:'',
                errors:{},
                error_message:'',
            }
        },
        methods:{
            store(){
                let formdata = new FormData
                formdata.append('first_surname',this.first_surname)
                formdata.append('second_surname',this.second_surname)
                formdata.append('name',this.name)
                axios.post('/people',formdata).then(response=>{
                    this.clear()
                }).catch(error=>{
                    this.errors = error.response.data.errors
                    this.error_message = error.response.data.message
                })
            },
            clear(){
                this.first_surname = ''
                this.second_surname = ''
                this.name = ''
                this.errors = {}
                this.error_message = ''
            },
            showAlert(){
                console.log(this.error_message)
            }
        }
    }
</script>
