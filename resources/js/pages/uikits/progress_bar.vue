<template>
    <div>
        <Breadcrumbs main="UI Kits" title="Progress" />

        <div class="container-fluid">
            <div class="row">
                <BasicProgressBars />
                <SizingProgressBars />
                <CustomHeightProgressBars />
                <Multiplebars />
                <ProgressBarsStriped />
                <ProgressBarsanimated />
            </div>
        </div>

    </div>
</template>

<script>
import BasicProgressBars from './progress_bar/BasicProgressBars.vue';
import SizingProgressBars from "./progress_bar/SizingProgressBars.vue"
import CustomHeightProgressBars from "./progress_bar/CustomHeightProgressBars.vue"
import Multiplebars from "./progress_bar/Multiplebars.vue"
import ProgressBarsStriped from "./progress_bar/ProgressBarsStriped.vue"
import ProgressBarsanimated from "./progress_bar/ProgressBarsanimated.vue"

export default {
    components: {
        BasicProgressBars,
        SizingProgressBars,
        CustomHeightProgressBars,
        Multiplebars,
        ProgressBarsStriped,
        ProgressBarsanimated
    }
};
</script>
