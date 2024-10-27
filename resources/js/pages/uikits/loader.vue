<template>
  <Breadcrumbs main="UI Kits" title="Spinners" />

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>Loader Style</h5>
          </div>
          <div class="card-body row">
            <div class="col-sm-6 col-md-3" v-for="loader in spinners" :key="loader">
              <h6 class="sub-title mb-0 text-center">{{ loader.title }}</h6>
              <div class="loader-box">
                <div :class="loader.loaderClass"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { loader } from "../../data/uikits/data"
export default {
  data() {
    return {
      spinners: loader
    }
  },
};
</script>