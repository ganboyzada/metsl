<template>
<div>
    <Breadcrumbs main="" title="File Manager" />
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 box-col-6 pe-0">
                <div class="md-sidebar"><a class="btn btn-primary md-sidebar-toggle" href="javascript:void(0)" @click="collapse()">file filter</a>
                    <div class="md-sidebar-aside job-left-aside custom-scrollbar" :class="filtered?'open':''">
                        <SideBarCard />
                    </div>
                </div>
            </div>
            <ContentCard />
        </div>
    </div>
</div>
</template>

<script>
import SideBarCard from "../pages/filemanager/SideBarCard.vue"
import ContentCard from "../pages/filemanager/ContentCard.vue"
export default {
    components: {
        SideBarCard,
        ContentCard
    },
    data() {
        return {
            filtered: false,
        }
    },
    methods: {
        collapse() {
            this.filtered = !this.filtered
        }
    }
}
</script>
