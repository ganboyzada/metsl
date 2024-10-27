<template>
  <div class="col-sm-12 col-xxl-6 box-col-12">
    <div class="card height-equal">
      <div class="card-header ">
        <h5>Vertical Style</h5><span>For Create inline megaoption add <code>.mega-vertical</code> class in form tag</span>
      </div>
      <div class="card-body">
        <deliveryOption />
      </div>
      <div class="card-footer text-end">
        <button class="btn btn-primary m-r-15" type="submit">Submit</button>
        <button class="btn btn-light" type="submit">Cancel</button>
      </div>
    </div>
  </div>
</template>
<script>
import deliveryOption from "./deliveryOption.vue"
export default {
  components: { deliveryOption },
  data() {
    return {
      verticalStyle: 1
    }
  }
}
</script>