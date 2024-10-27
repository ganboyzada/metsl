<template>
  <div class="col-sm-12 box-col-12">
       <div class="card">
         <div class="card-header">
           <h3>MASONRY GALLERY</h3>
         </div>
         <div class="card-body photoswipe-pb-responsive" itemprop="associatedMedia" itemscope>
           <div
             v-masonry
             transition-duration="3s"
             item-selector=".item"
             class="masonry-container isotopeContainer row my-gallery grid gallery"
           >
             <div
               v-masonry-tile
               class="col-md-3 col-sm-6 isotopeSelector grid-item item"
               :key="index"
               v-for="(item, index) in imagearray"
               @click="() => showImg(index)"
             >
             <img :src="item.imagepath" alt="Image description" class="img-thumbnail" />
             </div>
           </div>
           <vue-easy-lightbox
           :visible="visible"
           :index="index"
           :imgs="lightBoxImages" 
           @hide="handleHide"
             >
           </vue-easy-lightbox>
         </div>
       </div>
     </div>
</template>
<script>
import {imagearray  } from "../../../data/gallery/masonryPage"
export default {
 data() {
 return {  
   lightBoxImages:[],
         visible: false,
         index:'', 
   imagearray: imagearray
 };
},
methods: {
   showImg (index) {
     this.index = index
     this.visible = true
   },
   handleHide () {
     this.visible = false
   },
 },
mounted() {
 if (typeof this.$redrawVueMasonry === 'function') {
     this.$redrawVueMasonry();
   } 
   this.imagearray.forEach(item=>{
         this.lightBoxImages.push(item.imagepath)
     })
},
}
</script>