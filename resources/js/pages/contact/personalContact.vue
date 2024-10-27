<template>
<div class="card mb-0">
    <div class="card-header d-flex">
        <h5>Personal</h5><span class="f-14 pull-right mt-0">{{menu.length}} Contacts</span>
    </div>
    <div class="card-body p-0">
        <div class="row list-persons" id="addcon">
            <div class="col-xl-4 xl-50 col-md-5">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="contact-tab-0 nav-link" :class="this.activeTab==item.activeTab ? 'active show' : ''" id="v-pills-user-tab" data-bs-toggle="pill" @click="activeDiv(item.activeTab)" href="#v-pills-user" role="tab" aria-controls="v-pills-user" aria-selected="true" v-for="(item,index) in menu" :key="index">
                        <div class="media"><img class="img-50 img-fluid m-r-20 rounded-circle update_img_0" :src="item.imgUrl || getImgUrl(item.img)" alt="">
                            <div class="media-body">
                                <h6> <span class="first_name_0">{{item.name}} </span><span class="last_name_0">{{item.lastName}}</span></h6>
                                <p class="email_add_0">{{item.email}}</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
            <Generalpersonal />
        </div>
    </div>
</div>
</template>

<script>
import Generalpersonal from './Generalpersonal.vue'
import data from '@/data/contact.json'
import historyPage from './historyPage.vue'
import editPage from './editPage.vue'
import {
    mapGetters
} from 'vuex'
export default {
    components: {
        historyPage,
        editPage,
        Generalpersonal
    },
    data() {
        return {
            data: data,
        }
    },
    computed: {
        ...mapGetters({
            activeTab: 'contact/activeTab',
        }),
        menu() {
            return this.data.data
        }
    },

    methods: {
        activeDiv(item) {
            this.$store.dispatch('contact/active', item)

        },
        getImgUrl(path) {
            return require('../../assets/images/' + path)
        },

    }
}
</script>
