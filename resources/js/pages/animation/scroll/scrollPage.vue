<template>
<Breadcrumbs main="Animation" title="Scroll Reveal" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Scroll Reveal Example</h5>
                </div>
                <div class="card-body">
                    <div class="row gallery my-gallery" id="aniimated-thumbnials" itemscope="">
                        <figure class="reveal col-xl-3 col-md-4 col-sm-6 box-col-33" v-for="(item,index) in imgs" :key="index" @click="() => showImg(index)">
                            <img v-animate-onscroll.repeat="{ down: 'animated zoomInUp', up: 'animated rotateOut'}" class="img-thumbnail" :src="getImgUrl(item.image)" itemprop="thumbnail" alt="Image description">
                            <figcaption itemprop="caption description">Image caption {{index+1}}</figcaption>
                        </figure>
                    </div>
                    <vue-easy-lightbox :visible="visible" :index="index" :imgs="lightBoxImages[index]" @hide="handleHide">
                    </vue-easy-lightbox>
                </div>
            </div>
        </div>
    </div>
</div>
{{ title }}
</template>
<script>
import {scroll} from '@/data/animation'
import { myMixin } from '@/myMixin'
export default {
mixins:[myMixin],
    data() {
        return {
            lightBoxImages: [],
            visible: false,
            index: '',
            imgs:scroll
        }
    },
    methods: {
        showImg(index) {

            this.index = index
            this.visible = true
        },
        handleHide() {
            this.visible = false
        },
        getImgUrl(path) {
            return require('@/assets/images/lightgallry/' + path)
        }
    },
    mounted() {
        this.imgs.forEach(item => {
            this.lightBoxImages.push(require('@/assets/images/lightgallry/' + item.image))
        })
    }
}
</script>
