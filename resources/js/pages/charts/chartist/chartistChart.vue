<template>
<div class="col-md-6 col-sm-12 box-col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h5>Advanced SMIL Animations</h5>
        </div>
        <div class="card-body">
            <chartist class="ct-6 flot-chart-container" ratio="ct-major-second" type="Line" :data="chart1.data" :options="chart1.options" :event-handlers="chart1.eventHandlers">
            </chartist>

        </div>
    </div>
</div>
</template>

<script>
var seq = 0;
var delays = 80;
var durations = 500;
import {
    chartist
} from '@/data/apexChart'
export default {
    data() {
        return {

            chart1: chartist
        }
    }
}
</script>
