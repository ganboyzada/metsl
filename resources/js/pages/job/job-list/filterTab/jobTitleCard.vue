<template>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-start collapsed" type="button" data-bs-target="#collapseThree"
          :aria-expanded="active2 ? 'false' : 'true'" aria-controls="collapseThree" @click="showOpen2">Job Title</button>
      </h2>
    </div>
    <div class="collapse" :class="active2 ? '' : 'show'" id="collapseThree" aria-labelledby="headingThree"
      data-bs-parent="#accordionExample">
      <div class="card-body animate-chk">
        <label class="d-block" for="chk-ani11">
          <input class="checkbox_animated" id="chk-ani11" type="checkbox"> UI/Ux designer(25)
        </label>
        <label class="d-block" for="chk-ani12">
          <input class="checkbox_animated" id="chk-ani12" type="checkbox"> Graphic designer(10)
        </label>
        <label class="d-block" for="chk-ani13">
          <input class="checkbox_animated" id="chk-ani13" type="checkbox"> Front end designer(15)
        </label>
        <label class="d-block" for="chk-ani14">
          <input class="checkbox_animated" id="chk-ani14" type="checkbox"> PHP developer(42)
        </label>
        <label class="d-block mb-0" for="chk-ani15">
          <input class="checkbox_animated" id="chk-ani15" type="checkbox"> React Developer(5)
        </label>
      </div>
      <button class="btn btn-block btn-primary text-center" type="button">All Job Title</button>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {

      active2: false,
    }
  },
  methods: {
    showOpen2() {
      this.active2 = !this.active2
    },
  },
}
</script>