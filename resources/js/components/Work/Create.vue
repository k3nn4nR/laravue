<template>
    <div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createmodal" data-bs-backdrop="static">
            Add Work
        </button>
        <div class="modal fade" id="createmodal" refs="createmodal" style="display: none;" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Work Registration</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="Work">Work</label>
                                        <input type="text" id="Work" class="form-control" v-model="work">
                                        <div v-if="errors">
                                            <div v-for="(error,e) in errors.work" :key="e"><p class="text-danger">{{ error }}</p></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" @click="store">Submit</button>
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
                work:'',
                errors:{},
            }
        },
        mounted(){

        },
        methods:{
            store(){
                let formdata = new FormData
                formdata.append('work',this.work)
                axios.post('/work',formdata).then(response=>{

                })
            }
        }
    }
</script>