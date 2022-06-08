<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <item-create/>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped table-bordered" id="my-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Code</th>
                                            <th scope="col">Item</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in items" :key="item.id">
                                            <td>{{ item.code.code }}</td>
                                            <td>{{ item.item }}</td>
                                            <td>
                                                <i class="fas fa-edit" @click="edit(item.code.code)" ></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import datatable from 'datatables.net-bs5'
    import $ from 'jquery'
    import ItemCreate from './Create.vue'
    export default {
        components:{
            ItemCreate,
        },
        props:['user'],
        data(){
            return {
                items:[],
            }
        },
        mounted(){ 
            this.getData();
            Echo.channel('itemregistration').listen('ItemRegisteredEvent',(e) => {
                this.getData();
            });
        },
        methods:{
            table(){
                this.$nextTick(()=>{
                    $('#my-table').DataTable();
                })
            },
            getData(){
                axios.get('/item').then(response=>{
                    this.items = response.data;
                    $('#my-table').DataTable().destroy();
                    this.table();
                })
            },
            edit(id){
                window.location.href = '/item/'+id+'/edit'
            },
        }
    }
</script>
