<template>
    <div>

    </div>
</template>

<script>
    export default {
        props:['id_number'],
        data(){
            return {
                person:{},
                documents:[],
                contracts:[],
            }
        },
        mounted(){
            this.getData();
            Echo.channel('personupdated').listen('PersonUpdateEvent',(e) => {
                this.getData();
            });
        },
        methods: {
            getData(){
                axios.get('/people/'+this.id_number).then(response=>{
                    this.person = response.data.person
                    this.documents = response.data.documents
                    this.contracts = response.data.contracts
                })
            }
        },
    }
</script>
