<template>
    <Breadcrumbs main="Ecommerce" title="Product Page" />

    <div class="container-fluid">
        <div>
            <div class="row product-page-main p-0">
                <ProductSwiper />
                <ProductDetailsCard />
                <BrandCard />
            </div>
        </div>
        <div class="card">
            <div class="row product-page-main">
                <ProductExtraDetails />
            </div>
        </div>
    </div>
</template>

<script>
import ProductSwiper from "./ProductSwiper.vue";
import ProductDetailsCard from "./ProductDetailsCard.vue";
import BrandCard from "./BrandCard.vue";
import ProductExtraDetails from "./ProductExtraDetails.vue";
export default {
    name: "productPage",
    components: {
        ProductSwiper,
        ProductDetailsCard,
        BrandCard,
        ProductExtraDetails
    },
};
</script>
