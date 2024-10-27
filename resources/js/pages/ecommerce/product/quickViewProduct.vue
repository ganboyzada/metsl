<template>
    <div class="modal-header">
        <div class="product-box row">
            <div class="product-img col-lg-6">
                <img class="img-fluid" v-if="quickViewProduct.images" :src="getImageUrl(quickViewProduct.images[0])" alt="">
            </div>
            <div class="product-details col-lg-6 text-start">
                <h4>{{ quickViewProduct.name }}</h4>
                <div class="product-price">${{ quickViewProduct.price }}
                    <del>{{ quickViewProduct.salePrice }}</del>
                </div>
                <div class="product-view">
                    <h6 class="f-w-600">Product Details</h6>
                    <p class="mb-0">Cotton Solid Men's Fashion Full Sleeves Latest Jacket for Men With Button
                        Closure Long
                        Sleeve Casual Torn Lycra Denim Jacket.</p>
                </div>
                <div class="product-size">
                    <ul class="d-flex my-3">
                        <li>
                            <button class="btn btn-outline-light" type="button">M</button>
                        </li>
                        <li>
                            <button class="btn btn-outline-light ms-1" type="button">L</button>
                        </li>
                        <li>
                            <button class="btn btn-outline-light ms-1" type="button">Xl</button>
                        </li>
                    </ul>
                </div>
                <div class="product-qnty">
                    <h6 class="f-w-600">Quantity</h6>
                    <fieldset>
                        <div class="input-group bootstrap-touchspin mb-3">
                            <button class=" btn btn-primary btn-square bootstrap-touchspin-down " type="button"
                                data-bs-original-title="" title="" @click="decrement()">
                                <i class="fa fa-minus"></i></button>
                            <input class="touchspin1 text-center" v-model="counter" name="quantity" type="text" />
                            <button class="btn btn-primary btn-square bootstrap-touchspin-up" type="button"
                                data-bs-original-title="" title="" @click="increment()">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </fieldset>
                    <div class="addcart-btn">
                        <router-link to="/ecommerce/cart" class="btn btn-primary" data-bs-dismiss="modal"
                            @click="addToCart(quickViewProduct, counter)">Add to Cart</router-link>
                        <router-link :to="'/ecommerce/productPage'" class="btn btn-primary ms-2"
                            data-bs-dismiss="modal">View Details</router-link>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
</template>
<script>
import productMixin from "@/mixins/commen/productMixin"
import getImage from "@/mixins/getImage"
import quickViewProduct from './quickViewProduct.vue';

export default {
    name: 'productView',
    mixins: [productMixin, getImage],
    components: {
        quickViewProduct
    },

}
</script>
