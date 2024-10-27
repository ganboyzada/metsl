<template>
    <Breadcrumbs title="Contacts" />


    <div class="container-fluid">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                <div class="col-xl-3 box-col-6">
                    <div class="md-sidebar"><a class="btn btn-primary md-sidebar-toggle" href="javascript:void(0)"
                            @click="collapseFilter">contact filter </a>
                        <div class="md-sidebar-aside email-left-aside custom-scrollbar" :class="filtered ? 'open' : ''">
                            <div class="card">
                                <div class="card-body">
                                    <div class="email-app-sidebar left-bookmark">
                                        <div class="media">
                                            <div class="media-size-email"><img class="me-3 rounded-circle"
                                                    src="@/assets/images/user/user.png" alt=""></div>
                                            <div class="media-body">
                                                <h6 class="f-w-700">MARK JENCO</h6>
                                                <p>Markjecno@gmail.com</p>
                                            </div>
                                        </div>
                                        <ul class="nav main-menu contact-options" role="tablist">
                                            <newContact />
                                            <li class="nav-item"><span class="main-title"> Views</span></li>
                                            <li><a id="pills-personal-tab" data-bs-toggle="pill" href="#pills-personal"
                                                    role="tab" aria-controls="pills-personal" aria-selected="true"><span
                                                        class="title" v-on:click="active('pills-personal-tab')">
                                                        Personal</span></a></li>
                                            <addCategory />
                                            <li><a class="show" id="pills-organization-tab" data-bs-toggle="pill"
                                                    href="#pills-organization" role="tab" aria-controls="pills-organization"
                                                    aria-selected="false"><span class="title"
                                                        v-on:click="active('pills-organization-tab')">
                                                        Organization</span></a></li>
                                            <li><a href="javascript:void(0)"><span class="title">Follow up</span></a></li>
                                            <li><a href="javascript:void(0)"><span class="title">Favorites</span></a></li>
                                            <li><a href="javascript:void(0)"><span class="title">Ideas</span></a></li>
                                            <li><a href="javascript:void(0)"><span class="title">Important</span></a></li>
                                            <li><a href="javascript:void(0)"><span class="title">Business</span></a></li>
                                            <li><a href="javascript:void(0)"><span class="title">Holidays</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-12 box-col-12">
                    <div class="email-right-aside bookmark-tabcontent contacts-tabs">
                        <div class="card email-body radius-left">
                            <div class="ps-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade"
                                        v-bind:class="(activeclass === 'pills-personal-tab') ? 'active show' : ''"
                                        id="pills-personal" role="tabpanel" aria-labelledby="pills-personal-tab">
                                        <personalContact />
                                    </div>
                                    <div class="fade tab-pane"
                                        v-bind:class="(activeclass === 'pills-organization-tab') ? 'active show' : ''"
                                        id="pills-organization" role="tabpanel" aria-labelledby="pills-organization">
                                        <organizationContact />
                                    </div>
                                    <printModal />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import printModal from './printModal.vue'
import newContact from './newContact.vue'
import addCategory from './addCategory.vue';
import personalContact from './personalContact.vue'
import organizationContact from './organizationContact.vue'
import menu from '../../data/contact.json'

export default {
    name: 'contactView',
    data() {
        return {
            activeclass: 'pills-personal-tab',
            menu: menu.data,
            filtered: false
        }
    },
    components: {
        newContact,
        addCategory,
        personalContact,
        organizationContact,
        printModal
    },
    methods: {
        active(item) {
            this.activeclass = item
        },
        collapseFilter() {
            this.filtered = !this.filtered
        }
    },
}
</script>
