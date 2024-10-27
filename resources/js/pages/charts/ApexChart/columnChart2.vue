<template>
<div class="col-sm-12 col-xl-12 box-col-6">
    <div class="card">
        <div class="card-header pb-0">
            <h3>Column Chart</h3>
        </div>
        <div class="card-body">
            <div id="annotationchart">
                <apexchart height="350" type="line" :options="apexChart.chartOptions1" :series="series"></apexchart>
            </div>
        </div>
    </div>
</div>
</template>

<script>
var primary = localStorage.getItem('primary_color') || '#24695c';
import chart from "@/data/chart.json";
import {
    apexChart
} from '@/data/apexChart'
export default {
    data() {
        return {
            series: [{
                data: chart.monthDataSeries1.prices,
            }, ],
            apexChart: apexChart
        }
    },
    mounted() {
        this.series[0].data = chart.monthDataSeries1.prices;
    },
}
</script>
