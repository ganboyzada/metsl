<template>
    <div class="col-xxl-5 box-col-6 order-xxl-0 order-1">
        <div class="card">
            <div class="card-body">
                <div class="product-page-details">
                    <h3>{{ products.name }}</h3>

                </div>
                <div class="product-price">
                    ${{ products.price }}
                    <del>${{ products.discountPrice }} </del>
                </div>
                <ul class="product-color">
                    <li class="bg-primary"></li>
                    <li class="bg-secondary"></li>
                    <li class="bg-success"></li>
                    <li class="bg-warning"></li>
                    <li class="bg-danger"></li>
                </ul>
                <hr />
                <p>
                    {{ products.discription }}
                </p>
                <hr />
                <productSocial />
                <hr />
                <div class="m-t-15 btn-showcase">
                    <router-link class="btn btn-primary" :to="'/ecommerce/cart'" title="">
                        <i class="fa fa-shopping-basket me-1"></i>Add To
                        Cart</router-link>
                    <router-link class="btn btn-success" to="/ecommerce/checkout" title="">
                        <i class="fa fa-shopping-cart me-1"></i>Buy Now</router-link>
                    <router-link class="btn btn-secondary" to="/ecommerce/wishlist">
                        <i class="fa fa-heart me-1"></i>Add To WishList</router-link>
                </div>
            </div>
        </div>
</div>
</template>
<script>
import productPage from "@/mixins/productPage"
import productSocial from "./productSocial.vue"
export default {
    mixins: [productPage],
    components: {
        productSocial
    },
    name: "productPage",
};
</script>