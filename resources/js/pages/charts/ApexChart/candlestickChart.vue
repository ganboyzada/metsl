<template>
<div class="col-sm-12 col-xl-12 box-col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h3>Candlestick Chart</h3>
        </div>
        <div class="card-body">
            <div id="candlestick">
                <apexchart type="candlestick" height="350" :series="apexchart.series" :options="apexchart.chartOptions"></apexchart>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    apexChart
} from '@/data/apexChart'
export default {
    data() {
        return {
            apexchart: apexChart
        }
    },

}
</script>
