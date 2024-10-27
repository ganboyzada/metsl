<template>
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-start" type="button" data-bs-target="#collapseOne"
          :aria-expanded="active ? 'false' : 'true'" aria-controls="collapseOne" @click="showOpen">Filter</button>
      </h2>
    </div>
    <div class="collapse " :class="active ? '' : 'show'" id="collapseOne" aria-labelledby="headingOne"
      data-bs-parent="#accordionExample">
      <div class="card-body filter-cards-view animate-chk">
        <div class="job-filter mb-2">
          <div class="faq-form">
            <input class="form-control" type="text" placeholder="Search.."><i class="search-icon"
              data-feather="search"></i>
          </div>
        </div>
        <div class="job-filter">
          <div class="faq-form">
            <input class="form-control" type="text" placeholder="location.."><i class="search-icon"
              data-feather="map-pin"></i>
          </div>
        </div>
        <div class="checkbox-animated">
          <label class="d-block" for="chk-ani">
            <input class="checkbox_animated" id="chk-ani" type="checkbox"> Full-time (8688)
          </label>
          <label class="d-block" for="chk-ani1">
            <input class="checkbox_animated" id="chk-ani1" type="checkbox">Contract (503)
          </label>
          <label class="d-block" for="chk-ani2">
            <input class="checkbox_animated" id="chk-ani2" type="checkbox">Part-time (288)
          </label>
          <label class="d-block" for="chk-ani3">
            <input class="checkbox_animated" id="chk-ani3" type="checkbox">Internship (236)
          </label>
          <label class="d-block" for="chk-ani4">
            <input class="checkbox_animated" id="chk-ani4" type="checkbox">Temporary (146)
          </label>
          <label class="d-block" for="chk-ani5">
            <input class="checkbox_animated" id="chk-ani5" type="checkbox">Commission (25)
          </label>
        </div>
        <button class="btn btn-primary text-center" type="button">Find jobs</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {

      active: false,
    }
  },
  methods: {
    showOpen() {
      this.active = !this.active
    },
  },
}
</script>