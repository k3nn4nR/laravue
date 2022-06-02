<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <div class="row">
                            <person-create/>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="my-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">First Surname</th>
                                            <th scope="col">Second Surname</th>
                                            <th scope="col">Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="person in people" :key="person.id">
                                            <td>{{ person.first_surname }}</td>
                                            <td>{{ person.second_surname }}</td>
                                            <td>{{ person.name }}</td>
                                            <td></td>
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
    import datatable from 'datatables.net'
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
        created(){
            Echo.channel('personregistration')
                .listen('PersonRegisteredEvent',(e) => {
                this.getData();
            });
        },
        mounted() {
        },
        methods:{
            getData(){
                axios.get('/people').then(response=>{
                    this.people = response.data;
                })
            }
        }
    }
</script>
