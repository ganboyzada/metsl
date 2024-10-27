<template>
  <div class="card">
    <div class="card-header" id="headingFour">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-start collapsed" type="button" data-bs-target="#collapseFour"
          :aria-expanded="active3 ? 'false' : 'true'" aria-controls="collapseFour" @click="showOpen3">Industry</button>
      </h2>
    </div>
    <div class="collapse" :class="active3 ? '' : 'show'" id="collapseFour" aria-labelledby="headingFour"
      data-bs-parent="#accordionExample">
      <div class="card-body animate-chk">
        <label class="d-block" for="chk-ani16">
          <input class="checkbox_animated" id="chk-ani16" type="checkbox"> Computer Software(14)
        </label>
        <label class="d-block" for="chk-ani17">
          <input class="checkbox_animated" id="chk-ani17" type="checkbox"> IT Engineer(10)
        </label>
        <label class="d-block" for="chk-ani18">
          <input class="checkbox_animated" id="chk-ani18" type="checkbox"> Service industry(20)
        </label>
        <label class="d-block" for="chk-ani19">
          <input class="checkbox_animated" id="chk-ani19" type="checkbox"> Accounting(34)
        </label>
        <label class="d-block mb-0" for="chk-ani20">
          <input class="checkbox_animated" id="chk-ani20" type="checkbox"> Financial Services(5)
        </label>
      </div>
      <button class="btn btn-block btn-primary text-center" type="button">All Industries</button>
    </div>
  </div>
</template>
<script>

export default {
  data() {
    return {

      active3: false,
    }
  },
  methods: {
    showOpen3() {
      this.active3 = !this.active3
    },
  },
}
</script>