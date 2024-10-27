<template>
    <div class="col-xxl-4 col-md-6 box-col-12">
        <div class="card">
            <div class="card-body">
                <Swiper :slidesPerView="1" :loop="true" :thumbs="{ swiper: thumbsSwiper }"
                    :autoplay="{ delay: 3500, disableOnInteraction: false }" :spaceBetween="30" :centeredSlides="true"
                    :modules="modules" dir="rtl" class="mySwiper">
                    <swiper-slide v-for="(product, index) in products.images" :key="index">
                        <img :src="getImageUrl(product)" :id="index" class="img-fluid bg-img" alt="index" />
                    </swiper-slide>
                </Swiper>
                <Swiper @swiper="setThumbsSwiper" :loop="true" :slidesPerView="3" :spaceBetween="3"
                    :watchSlidesProgress="true" :pagination="{
                        clickable: true,
                    }" :modules="modules" dir="rtl" class="Swiper mt-2">

                    <swiper-slide v-for="(product, index) in products.images" :key="index">
                        <img :src="getImageUrl(product)" :id="index" class="img-fluid bg-img" alt="index"
                            style="height:auto; " />
                    </swiper-slide>
                </Swiper>
            </div>
        </div>
</div>
</template>
<script>
import { ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import productPage from "@/mixins/productPage"
import getImage from "@/mixins/getImage"
import "swiper/css";
import { Autoplay, FreeMode, Navigation, Thumbs } from "swiper";

export default {
    mixins: [productPage, getImage],
    name: "productPage",
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        const thumbsSwiper = ref(null);
        const setThumbsSwiper = (swiper) => {
            thumbsSwiper.value = swiper;
        };
        return {
            modules: [Autoplay, Navigation, FreeMode, Thumbs],
            thumbsSwiper,
            setThumbsSwiper,
        };
    },
    methods: {
        filled(len) {
            this.selectedStars = len;
        },
        addToCart: function (product, qty) {
            product.quantity = qty ? qty : 1;
            this.$store.dispatch("product/addToCart", product);
        },
    },
};
</script>