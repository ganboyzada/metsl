<template>
    <div>
        <Breadcrumbs main="UI Kits" title="Modal" />

        <div class="container-fluid">
            <div class="row">
                <StaticExample />
                <BasicModel />
                <Varyingmodal />
                <Sizesmodal />
            </div>
        </div>

    </div>
</template>

<script>
import StaticExample from "./modal/StaticExample.vue"
import BasicModel from "./modal/BasicModel.vue"
import Varyingmodal from "./modal/Varyingmodal.vue"
import Sizesmodal from "./modal/Sizesmodal.vue";

export default {
    components: {
        StaticExample,
        BasicModel,
        Varyingmodal,
        Sizesmodal
    },
};
</script>
