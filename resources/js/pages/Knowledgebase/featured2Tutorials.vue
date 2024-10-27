<template>
    <div class="col-xl-3 xl-50 col-md-6 box-col-6">
        <px-card :actions="false" class="features-faq product-box">
            <template v-slot:headerCustom>
                <div class="faq-image product-img">
                    <img class="img-fluid" src="../../assets/images/faq/3.jpg" alt="" />
                    <div class="product-hover">
                        <ul>
                            <li><i class="icon-link"></i></li>
                            <li><i class="icon-import"></i></li>
                        </ul>
                    </div>
                </div>
            </template>
            <template v-slot:with-padding>
                <h6>UI Design</h6>
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo ligula eget dolor. Aenean massa. Cum sociis
                    natoque penatibus et magnis dis parturient montes, nascetur
                    ridiculus mus.
                </p>
            </template>
            <template v-slot:footer>
                <span>Dec 15, 2019</span><span class="pull-right"><i class="fa fa-star font-primary"></i><i
                        class="fa fa-star font-primary"></i><i class="fa fa-star font-primary"></i><i
                        class="fa fa-star font-primary"></i><i class="fa fa-star font-primary"></i></span>
            </template>
        </px-card>
    </div>
    <div class="col-xl-3 xl-50 col-md-6 box-col-6">
        <px-card :actions="false" class="features-faq product-box">
            <template v-slot:headerCustom>
                <div class="faq-image product-img">
                    <img class="img-fluid" src="../../assets/images/faq/4.jpg" alt="" />
                    <div class="product-hover">
                        <ul>
                            <li><i class="icon-link"></i></li>
                            <li><i class="icon-import"></i></li>
                        </ul>
                    </div>
                </div>
            </template>
            <template v-slot:with-padding>
                <h6>UX Design</h6>
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo ligula eget dolor. Aenean massa. Cum sociis
                    natoque penatibus et magnis dis parturient montes, nascetur
                    ridiculus mus.
                </p>
            </template>
            <template v-slot:footer>
                <span>Dec 15, 2019</span><span class="pull-right"><i class="fa fa-star font-primary"></i><i
                        class="fa fa-star font-primary"></i><i class="fa fa-star font-primary"></i><i
                        class="fa fa-star font-primary"></i><i class="fa fa-star font-primary"></i></span>
            </template>
        </px-card>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import pxcard from '../../components/Pxcard.vue'
export default {
    components: {
        'px-card': pxcard
    },
    data() {
        return {};
    },
    computed: {
        ...mapState({
            knowledgebasedata: (state) => state.common.knowledgebasedata,
        }),
    },
};
</script>