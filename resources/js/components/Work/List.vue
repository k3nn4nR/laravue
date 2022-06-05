<template>
    <div class="row">
        
    </div>
</template>

<script>
    import WorkCreate from './Create.vue'
    export default {
        components:{
            WorkCreate,
        },
        data(){
            return {
                inactives:'',
                actives:'',
                in_progress:'',
                finished:'',
            }
        },
        mounted(){
            this.getData();
            Echo.channel('workregistration').listen('WorkRegisteredEvent',(e) => {
                this.getData();
            });
        },
        methods: {
            getData(){
                axios.get('/work').then(response=>{
                    this.inactives = response.data.inactives
                    this.actives = response.data.actives
                    this.in_progress = response.data.in_progress
                    this.finished = response.data.finished
                })
            }
        },
    }
</script>
