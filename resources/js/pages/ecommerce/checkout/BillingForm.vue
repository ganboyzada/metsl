<template>
  <div class="col-xl-6 col-sm-12">
    <form>
      <div class="row">
        <div class="mb-3 col-sm-6">
          <label for="inputEmail4">First Name</label>
          <input class="form-control" id="inputEmail" v-model="user.firstName.value">
          <span class="validate-error" v-if="user.firstName.value.length === 0">{{
            user.firstName.errormsg
          }}</span>
        </div>
        <div class="mb-3 col-sm-6">
          <label for="inputPassword4">Last Name</label>
          <input class="form-control" id="input" v-model="user.lastName.value" type="text">
          <span class="validate-error" v-if="user.lastName.value.length === 0">{{
            user.lastName.errormsg
          }}</span>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 col-sm-6">
          <label for="phonenumber">Phone</label>
          <input class="form-control" id="phonenumber" v-model="user.phone.value" type="tel">
          <span class="validate-error" v-if="user.phone.value.length === 0">{{ user.phone.errormsg }}</span>
        </div>
        <div class="mb-3 col-sm-6">
          <label for="inputPassword7">Email Address</label>
          <input class="form-control" id="inputPassword7" v-model="user.email.value" type="email">
          <span class="validate-error" v-if="!user.email.value || !validEmail(user.email.value)">{{
            user.email.errormsg
          }}</span>
        </div>
      </div>
      <div class="mb-3">
        <label for="inputState">Country</label>
        <select class="form-control" id="inputState">
          <option selected="">Choose...</option>
          <option>@.</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="inputAddress5">Address</label>
        <input class="form-control" id="inputAddress5" v-model="user.address.value" type="text">
        <span class="validate-error" v-if="user.address.value.length === 0">{{
          user.address.errormsg
        }}</span>
      </div>
      <div class="mb-3">
        <label for="inputCity">Town/City</label>
        <input class="form-control" id="inputCity" v-model="user.city.value" type="text">
        <span class="validate-error" v-if="user.city.value.length === 0">{{ user.city.errormsg }}</span>
      </div>
      <div class="mb-3">
        <label for="inputAddress2">State/Country</label>
        <input class="form-control" id="inputAddress2" v-model="user.state.value" type="text">
        <span class="validate-error" v-if="user.state.value.length === 0">{{ user.state.errormsg }}</span>
      </div>
      <div class="mb-3">
        <label for="inputAddress6">Postal Code</label>
        <input class="form-control" id="inputAddress6" v-model="user.pincode.value" type="number">
        <span class="validate-error" v-if="user.pincode.value.length === 0">{{
          user.pincode.errormsg
        }}</span>
      </div>
      <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" id="gridCheck" type="checkbox">
          <label class="form-check-label" for="gridCheck">Check me out</label>
        </div>
      </div>
    </form>
</div>
</template>
<script>
import checkoutPage from "@/mixins/checkoutPage"
export default {
  mixins: [checkoutPage],
  data() {
    return {
      activeAmount: "0",
      totalAmount: 0,
      isLogin: false,
      user: {
        firstName: { value: '', errormsg: '' },
        lastName: { value: '', errormsg: '' },
        phone: { value: '', errormsg: '' },
        email: { value: '', errormsg: '' },
        address: { value: '', errormsg: '' },
        city: { value: '', errormsg: '' },
        state: { value: '', errormsg: '' },
        pincode: { value: '', errormsg: '' }
      },
      submitted: false,
      payment: false,
      complete: false,
      selectedPayment: 'stripe'
    }
  },
}
</script>