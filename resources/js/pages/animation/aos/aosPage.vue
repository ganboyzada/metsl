<template>
<Breadcrumbs main="Animation" title="AOS Animation" />

<div class="card">
    <div class="card-header">
        <h5>AOS Example animation</h5>
    </div>
    <div class="card-body">
        <div v-masonry class="row gallery grid my-gallery" id="aniimated-thumbnials">
            <figure v-masonry-tile class="grid-item col-sm-4 col-md-3" v-for="(src, index) in imgs" :key="index" @click="() => showImg(index)">
                <aos-vue :animation="src.animation">
                    <a>
                        <img :src="require('../../../assets/images/masonry/' + src.image)" alt="Image description" class="img-thumbnail" />
                    </a>
                </aos-vue>
            </figure>
        </div>
        <vue-easy-lightbox :index="index" :visible="visible" :imgs="lightBoxImages[index]" @hide="handleHide">
        </vue-easy-lightbox>
    </div>
</div>
</template>

<script>
import {aos} from '@/data/animation'
export default {
    data() {
        return {
            lightBoxImages: [],
            lightBoxTitle: [],
            visible: false,
            imgs: aos
        };
    },
    methods: {
        showImg(index) {
            this.index = index;
            this.visible = true;
        },
        handleHide() {
            this.visible = false;
        },
    },
    mounted() {
        this.imgs.forEach((item) => {
            this.lightBoxImages.push(
                require("@/assets/images/masonry/" + item.image)
            );
            this.lightBoxTitle.push(item.title);
        });
    },
};
</script>
