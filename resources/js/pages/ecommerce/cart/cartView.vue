<template>
    <Breadcrumbs main="Ecommerce" title="Cart" />
    <div class="container-fluid text-start">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Cart</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <emptyCart />
                            <div class="order-history table-responsive wishlist" v-if="cart.length">
                                <productCart />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState } from "vuex";
import emptyCart from "./emptyCart.vue"
import getImage from "@/mixins/getImage"
import productCart from "./productCart.vue"
export default {
    mixins: [getImage],
    components: { emptyCart, productCart },
    data() {
        return {
            counter: 1,
        };
    },
    computed: {
        ...mapState({
            cart: (state) => state.product.cart,
            getAmount() {
                return (this.totalAmount = this.$store.getters["product/getTotalAmount"]);
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