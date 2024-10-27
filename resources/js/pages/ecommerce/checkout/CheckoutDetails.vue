<template>
    <div class="title-box">
        <div class="checkbox-title">
            <h4 class="mb-0">Product </h4><span>Total</span>
        </div>
    </div>
    <ul class="qty" v-if="cart.length">
        <li v-for="(item, index) in cart" :key="index">
            {{ item.name }} × {{ item.quantity }}
            <span>${{ item.price * item.quantity }}</span>
        </li>
    </ul>
    <ul class="qty" v-if="!cart.length">
        <li v-if="!cart.length">There are no products in cart</li>
    </ul>
    <ul class="sub-total">
        <li>Subtotal <span class="count">${{ getAmount }}</span></li>
        <li class="shipping-class">Shipping
            <div class="shopping-checkout-option">
                <label class="d-block" for="chk-ani">
                    <input class="checkbox_animated" id="chk-ani" type="checkbox" checked="">Option 1
                </label>
                <label class="d-block" for="chk-ani1">
                    <input class="checkbox_animated" id="chk-ani1" type="checkbox">Option 2
                </label>
            </div>
        </li>
    </ul>
    <ul class="sub-total total">
        <li>Total <span class="count">${{ getAmount }}</span></li>
    </ul>
</template>

<script>
import checkoutPage from "@/mixins/checkoutPage"
import { mapState } from 'vuex';
export default {
    name: 'checkoutView',
    mixins: [checkoutPage],
    data() {
        return {

            totalAmount: 0,
            isLogin: false,
            submitted: false,
            payment: false,
            complete: false,
            selectedPayment: 'stripe'

        }
    },
    computed: {
        ...mapState({
            cart: state => state.product.cart,
            getAmount() {
                return (this.totalAmount = this.$store.getters[
                    'product/getTotalAmount'
                ]);
            }
        }),
    },
}
</script>
