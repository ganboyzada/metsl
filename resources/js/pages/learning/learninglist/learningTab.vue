<template>
  <div class="col-xl-3 xl-40 box-col-12 learning-filter">
    <div class="md-sidebar"><a class="btn btn-primary email-aside-toggle md-sidebar-toggle" @click="isOpen">Learning
        filter</a>
      <div class="md-sidebar-aside job-sidebar" :class="open ? 'open' : ''">
        <div class="default-according style-1 faq-accordion job-accordion" id="accordionoc">
          <div class="row">
            <findCourse />
            <categoriesPage />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import categoriesPage from "./categoriesPage.vue"
import findCourse from "./findCourse.vue"
export default {
  components: {
    categoriesPage,
    findCourse
  },
  methods: {
    isOpen() {
      this.open = !this.open
    },
  },
  data() {
    return {
      open: false,
      active: false,
    }
  }
}
</script>