<template>
    <div>

    </div>
</template>

<script>
    export default {
        props:['code'],
        data(){
            return {
                item:{},
                brands:[],
                models:[],  
            }
        },
        mounted(){
            this.getData();
            Echo.channel('itemupdated').listen('ItemUpdatedEvent',(e) => {
                this.getData();
            });
        },
        methods: {
            getData(){
                axios.get('/item/'+this.code).then(response=>{
                    this.item = response.data.item
                    this.brands = response.data.brands
                    this.models = response.data.models
                })
            }
        },
    }
</script>
