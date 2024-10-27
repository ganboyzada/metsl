<template>
<div class="card">
    <div class="card-header">
        <h5>Merge Example</h5>
    </div>
    <div class="card-body">
        <div class="owl-carousel owl-theme" id="owl-carousel-4">
            <swiper autoHeight: true :slides-per-view="3" :space-between="20" :pagination="{
              clickable: true,
            }" :modules="modules" :breakpoints="swiperOptions1.breakpoints">
                <swiper-slide v-for="(item,index) in menu" :key="index">
                    <div class="item"><img :src="getImgUrl(item.value)" alt="" class="img-fluid"></div>
                </swiper-slide>
            </swiper>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Auto Width Example</h5>
    </div>
    <div class="card-body">
        <div class="owl-carousel owl-theme" id="owl-carousel-5">
            <swiper autoHeight: true :slides-per-view="3" :space-between="20" :pagination="{
              clickable: true,
            }" :modules="modules">
                <swiper-slide v-for="(item,index) in menu" :key="index">
                    <div class="item"><img :src="getImgUrl(item.value)" alt="" class="img-fluid"></div>
                </swiper-slide>
            </swiper>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>URL Hash Navigations</h5>
    </div>
    <div class="card-body">
        <div class="owl-carousel owl-theme" id="owl-carousel-6">
            <swiper autoHeight: true :slides-per-view="3" :space-between="20" :pagination="{
              clickable: true,
            }" :modules="modules" :breakpoints="swiperOptions.breakpoints">
                <swiper-slide v-for="(item,index) in menu" :key="index">
                    <div class="item"><img :src="getImgUrl(item.value)" alt="" class="img-fluid"></div>
                </swiper-slide>
            </swiper>
        </div>
    </div>
</div>
</template>

<script>
import {
    Swiper,
    SwiperSlide
} from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import { owlData } from '../../../data/uikits/data' 
import { Pagination } from "swiper";
export default {
    components: {
        Swiper, SwiperSlide,
    },
    data() {
        return {
            menu: owlData,
            swiperOptions: {
                breakpoints: { 1000: { slidesPerView: 3 }, 600: { slidesPerView: 3 }, 0: { slidesPerView: 1 } }
            },
            swiperOptions1: {
                breakpoints: { 1000: { slidesPerView: 3 }, 767: { slidesPerView: 2 }, 0: { slidesPerView: 1 } }
            }
        }
    },
    setup() {
        return {
            modules: [Pagination],
        };
    },
    methods: {
        getImgUrl(path) {
            return require('@/assets/images/' + path)
        }
    }
}
</script>
