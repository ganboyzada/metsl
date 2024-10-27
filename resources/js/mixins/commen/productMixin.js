import { mapGetters, mapState} from 'vuex'

const productMixin = {
    data(){
        return{
            isActive: false,
           modalShow: false,
        quickViewProduct: [],
        counter: 1,
        priceArray: [],
        allfilters: [],
        items: [],
       filtered: false,
       filterQuery: "",
        allData: [],
        }
    },
    computed: {
        ...mapState({
            products: (state) => state.product.products,
            productslist: (state) => state.product.productslist,
        }),
        ...mapGetters({
            tags: "product/setTags",
            name: 'product/col2',
            col3: 'product/col3',
            col4: 'product/col4',
            col6: 'product/col6',
            listViewEnable: 'product/listViewEnable',
            filterPage: 'product/filterProducts',
        }),
    },
    methods: {
        grid2() {
            this.$store.commit('product/grid2', true);
        },
        grid3() {
            this.$store.commit('product/grid3');
        },
        grid4() {
            this.$store.commit('product/grid4');
        },
        grid6() {
            this.$store.commit('product/grid6');
        },
        listView() {
            this.$store.commit('product/listView');
        },
        gridView() {
            this.$store.commit('product/grid6');
        },
        disp() {
            this.isActive = !this.isActive
        },
        addToCart: function (product, qty) {
            product.quantity = qty ? qty : 1;
            this.$store.dispatch("product/addToCart", product);
        },
        quickView: function (product) {
            return (this.quickViewProduct = product);
        },
        quickViewClose: function () {
            this.modalShow = false;
        },
        increment() {
            if (this.counter < this.quickViewProduct.stock) this.counter++;
        },
        decrement() {
            if (this.counter > 1) this.counter--;
        },
    }
}

export default productMixin