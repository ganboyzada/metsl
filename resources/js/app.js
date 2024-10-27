import { createApp } from 'vue'

import App from './App.vue'
import router from './router';
import '@/assets/scss/app.scss'
import VueFeather from 'vue-feather';
import store from './store'
import Breadcrumbs from './components/bread_crumbs';
import VueApexCharts from "vue3-apexcharts";
import "bootstrap"
import settingPage from "./components/settingPage.vue" 
import DropZone from "dropzone-vue";
import 'bootstrap/dist/js/bootstrap.bundle'
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import PerfectScrollbar from 'vue3-perfect-scrollbar'
import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css'
import Toaster from "@meforma/vue-toaster";
import Vue3Tour from 'vue3-tour'
import 'vue3-tour/dist/vue3-tour.css'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import bcard from "./components/b-card.vue" 
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import VueAnimateOnScroll from 'vue3-animate-onscroll';
import { quillEditor } from "vue3-quill";
import Lightbox from 'vue-easy-lightbox'
import { VueMasonryPlugin } from 'vue-masonry';
import vue3StarRatings from "vue3-star-ratings";
import Datepicker from 'vue3-datepicker'
import VueNumber from "vue-number-animation";  
import SimpleTypeahead from 'vue3-simple-typeahead';
import 'vue3-simple-typeahead/dist/vue3-simple-typeahead.css';
import Multiselect from 'vue-multiselect'
import "vue-multiselect/dist/vue-multiselect.css"
import { createI18n } from 'vue-i18n'
import English from "./locales/en.json"
import Français from "./locales/fr.json"
import Português from "./locales/pt.json"
import Español from "./locales/es.json"
import Deutsch from "./locales/de.json"
import 简体中文 from "./locales/cn.json"
import لعربية from "./locales/ae.json"
import { defaultLocale, localeOptions } from './constants/config';
import Toast, {POSITION, useToast} from "vue-toastification";
import "vue-toastification/dist/index.css";

 const locale = (localStorage.getItem('currentLanguage') && localeOptions.filter(x => x.id === localStorage.getItem('currentLanguage')).length > 0) ? localStorage.getItem('currentLanguage') : defaultLocale;
 const i18n = createI18n({
 
  locale: locale,
  messages: {
   English: English,
    Español: Español,
    Deutsch: Deutsch,
    Français: Français,   
   Português: Português,
   简体中文: 简体中文,
   لعربية: لعربية,

    }
 });
createApp(App).use(Toast).use(i18n).use(SimpleTypeahead).use(VueMasonryPlugin).use(VueNumber).component("vue3-star-ratings", vue3StarRatings).use(quillEditor).use(Lightbox).use(store).use(VueSweetalert2).use(VueAnimateOnScroll).use(Vue3Toasity).use(Vue3Tour).use(Toaster).use(router).component("settingPage", settingPage).component("b-card", bcard).use(PerfectScrollbar).use(DropZone).component('multiselect', Multiselect).component(VueFeather.name, VueFeather).component('Breadcrumbs', Breadcrumbs).component("apexchart", VueApexCharts).component('EasyDataTable', Vue3EasyDataTable).use(require('vue-chartist')).component('Datepicker', Datepicker).mount('#app')

