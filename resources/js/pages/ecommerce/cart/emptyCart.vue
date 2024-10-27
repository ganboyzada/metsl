<template>
    <div class="col-sm-12 empty-cart-cls text-center" v-if="!cart.length">
        <img :src="getImageUrl('ecommerce/icon-empty-cart.png')" class="img-fluid mb-4" />
        <h3><strong>Your Cart is Empty</strong></h3>
        <h4>Add something to make me happy :)</h4>
        <router-link :to="'/ecommerce/product'" class="btn btn-primary cart-btn-transform m-t-15">continue
            shopping</router-link>
</div>
</template>
<script>
import { mapState } from "vuex";
import getImage from "@/mixins/getImage"
export default {
    mixins: [getImage],
    components: {},
    data() {
        return {
            counter: 1,
        };
    },
    computed: {
        ...mapState({
            cart: (state) => state.product.cart,
            getAmount() {
                return (this.totalAmount =
                    this.$store.getters["product/getTotalAmount"]);
            },
        }),
    },
    methods: {
        removeProduct: function (product) {
            this.$store.dispatch("product/removeProduct", product);
        },
        increment(product, qty = 1) {
            this.$store.dispatch("product/updateCartQuantity", {
                product: product,
                qty: qty,
            });
        },
        decrement(product, qty = -1) {
            this.$store.dispatch("product/updateCartQuantity", {
                product: product,
                qty: qty,
            });
        },
    },
};
</script>
