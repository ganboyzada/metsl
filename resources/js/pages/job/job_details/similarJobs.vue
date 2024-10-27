<template>
    <div class="header-faq">
        <h6 class="mb-0 f-w-600">Similar jobs</h6>
    </div>
    <div class="row">
        <div class="col-xl-6 box-col-12 xl-100" v-for="(j, index) in jobslist" :key="index">
            <div class="card">
                <div class="job-search">
                    <div class="card-body">
                        <div class="media"><img class="img-40 img-fluid m-r-20" :src="getImgUrl(j.image)" alt="">
                            <div class="media-body">
                                <h6 class="f-w-600">
                                    <router-link :to="{ name: 'jobdetails', params: { id: j.id } }">{{ j.title
                                    }}</router-link>
                                    <span class="pull-right" v-if="j.date" v-text="j.date"></span>
                                    <span class="badge badge-primary pull-right" v-else>New</span>
                                </h6>
                                <p>{{ j.company }} <span>{{ j.city }}, {{ j.country }} </span><span
                                        v-html="stars(j.stars)"></span></p>
                            </div>
                        </div>
                        <p v-html="j.description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {
    mapState
} from 'vuex';
import router from '@/router';
import jobtab from "../job-list/jobTab.vue"
export default {
    components: {
        jobtab
    },
    props: ['id'],
    computed: {
        ...mapState({
            jobs: state => state.jobs.jobs.find(job => {
                if (parseInt(router.currentRoute._rawValue.params.id) === job.id)
                    return job;
            }),
            jobslist: state => state.jobs.jobs,
        })
    },
    methods: {
        getImgUrl(filename) {
            var images = require.context('../../../assets/images/job-search/', false, /\.jpg$/);
            return images('./' + filename);
        },
        stars(count) {
            var stars = '';
            for (var i = 0; i < 5; i++) {
                if (count > i) {
                    stars = stars + '<i class="fa fa-star font-warning"></i>';
                } else {
                    stars = stars + '<i class="fa fa-star font-warning-o"></i>';
                }
            }
            return stars;
        }
    }
}
</script>
