<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                        <br>
                        {{ user.id }}
                        <person-list/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PersonList from './People/List.vue'
    export default {
        components:{
            PersonList,
        },
        props:['user'],
        data(){
            return {

            }
        },
        mounted() {
            
        },
        methods:{

        }
    }
</script>
