<template>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ total }}</h3>
                    <p>People Registered</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a @click="human_resources" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ new_people }}</h3>
                    <p>Person New Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>
                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="row">
            <div id="chart" ></div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                total:'',
                new_people:'',
            }
        },
        mounted(){
            this.getData();
            Echo.channel('personregistration').listen('PersonRegisteredEvent',(e) => {
                this.getData();
            });
        },
        methods:{
            getData(){
                axios.get('/people-dashboard').then(response=>{
                    this.total = response.data.total
                    this.new_people = response.data.new_people
                    var options = {
                        chart: {
                            type: 'line'
                        },
                        series: [{
                            name: 'Person',
                            data: response.data.people_count
                        }],
                        xaxis: {
                            categories: response.data.people_keys
                        }
                    }
                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                })
            },
            human_resources(){
                window.location.href = '/human_resources'
            }
        }
    }
</script>