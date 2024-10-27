<template>
  <div class="col-xl-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">
          <button class="btn btn-link" data-bs-target="#collapseicon1" :aria-expanded="active1 ? 'false' : 'true'"
            aria-controls="collapseicon1" @click="showOpen1">Categories</button>
        </h5>
      </div>
      <div class="collapse card-body px-0 " :class="active1 ? '' : 'show'" id="collapseicon1"
        aria-labelledby="collapseicon1" data-bs-parent="#accordion">
        <div class="categories">
          <div class="learning-header"><span class="f-w-600">Design</span></div>
          <ul>
            <li><a href="#">UI Design </a><span class="badge badge-primary pull-right">28</span></li>
            <li><a href="#">UX Design </a><span class="badge badge-primary pull-right">35</span></li>
            <li><a href="#">Interface Design </a><span class="badge badge-primary pull-right">17</span></li>
            <li><a href="#">User Experience </a><span class="badge badge-primary pull-right">26</span></li>
          </ul>
        </div>
        <div class="categories pt-0">
          <div class="learning-header"><span class="f-w-600">Development</span></div>
          <ul>
            <li><a href="#">Frontend Development</a><span class="badge badge-primary pull-right">48</span></li>
            <li><a href="#">Backend Development</a><span class="badge badge-primary pull-right">19</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <upcomingCourses />
</template>
<script>
import upcomingCourses from "./upcomingCourses.vue"
export default {
  components: {
    upcomingCourses
  },
  methods: {
    showOpen1() {
      this.active1 = !this.active1
    },
  },
  data() {
    return {
      isActive: 'sub',
      active1: false
    }
  }
}
</script>