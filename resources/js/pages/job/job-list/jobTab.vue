<template>
    <div class="col-xl-3 xl-40 box-col-12">
        <div class="md-sidebar">
            <a class="btn btn-primary email-aside-toggle md-sidebar-toggle" @click="isOpen">Job filter</a>
            <div class="md-sidebar-aside job-sidebar" :class="open ? 'open' : ''">
                <div class="default-according style-1 faq-accordion job-accordion">
                    <div class="accordion" id="accordionExample">
                        <filterCard />

                        <locationCard />

                        <jobTitleCard />

                        <industyCard />

                        <skillsCard />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import filterCard from "./filterTab/filterCard.vue"
import locationCard from "./filterTab/locationCard.vue"
import jobTitleCard from "./filterTab/jobTitleCard.vue"
import industyCard from "./filterTab/industyCard.vue"
import skillsCard from "./filterTab/skillsCard.vue"
export default {
    components: {
        filterCard,
        locationCard,
        jobTitleCard,
        industyCard,
        skillsCard
    },

    methods: {
        isOpen() {
            this.open = !this.open
        },
    },
    data() {
        return {
            open: false,
        }
    }
}
</script>
