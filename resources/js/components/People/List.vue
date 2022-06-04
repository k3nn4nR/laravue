<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <person-create/>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="my-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID Number</th>
                                            <th scope="col">First Surname</th>
                                            <th scope="col">Second Surname</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="person in people" :key="person.id">
                                            <td>{{ person.person_documents[person.person_documents.length-1].id_number }}</td>
                                            <td>{{ person.first_surname }}</td>
                                            <td>{{ person.second_surname }}</td>
                                            <td>{{ person.name }}</td>
                                            <td>{{ person.status[person.status.length-1].status }}</td>
                                            <td>
                                                <i class="fas fa-edit" ></i>
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
    import datatable from 'datatables.net-bs4'
    import $ from 'jquery'
    import PersonCreate from './Create.vue'
    export default {
        components:{
            PersonCreate,
        },
        props:['user'],
        data(){
            return {
                people:[],
            }
        },
        mounted(){
            this.getData();
            Echo.channel('personregistration').listen('PersonRegisteredEvent',(e) => {
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
                axios.get('/people').then(response=>{
                    this.people = response.data;
                    $('#my-table').DataTable().destroy();
                    this.table();
                })
            }
        }
    }
</script>
