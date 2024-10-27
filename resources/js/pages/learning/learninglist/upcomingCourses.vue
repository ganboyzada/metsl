<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-bs-target="#collapseicon2" :aria-expanded="active2 ? 'false' : 'true'"
                        aria-controls="collapseicon2" @click="showOpen2">Upcoming Courses</button>
                </h5>
            </div>
            <div class="collapse " :class="active2 ? '' : 'show'" id="collapseicon2" aria-labelledby="collapseicon2"
                data-bs-parent="#accordion">
                <div class="upcoming-course card-body">
                    <div class="media">
                        <div class="media-body"><span class="f-w-600">UX Development</span><span class="d-block">Course By
                                <a href="#"> Lorem ipsum</a></span><span class="d-block"><i
                                    class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i
                                    class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i
                                    class="fa fa-star-half-o font-warning"></i></span></div>
                        <div>
                            <h5 class="mb-0 font-primary">18</h5><span class="d-block">Dec</span>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-body"><span class="f-w-600">Business Analyst</span><span class="d-block">Course By
                                <a href="#">Lorem ipsum </a></span><span class="d-block"><i
                                    class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i
                                    class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i
                                    class="fa fa-star font-warning"></i></span></div>
                        <div>
                            <h5 class="mb-0 font-primary">28</h5><span class="d-block">Dec</span>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-body"><span class="f-w-600">Web Development</span><span class="d-block">Course By
                                <a href="#">Lorem ipsum </a></span><span class="d-block"><i
                                    class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i
                                    class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i
                                    class="fa fa-star-o font-warning"></i></span></div>
                        <div>
                            <h5 class="mb-0 font-primary">5</h5><span class="d-block">Jan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        showOpen2() {
            this.active2 = !this.active2
        },
    },
    data() {
        return {
            active2: false
        }
    }
}
</script>