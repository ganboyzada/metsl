<template>
    <Breadcrumbs main="Ecommerce" title="Recent Orders" />

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <NewOrders />
                <ShippedOrders />
                <CancelledOrders />
            </div>
            <div class="col-sm-12">
                <DatatableOrderHistory />
            </div>
        </div>
    </div>
</template>

<script>
import NewOrders from './NewOrders.vue';
import ShippedOrders from './ShippedOrders.vue';
import CancelledOrders from './CancelledOrders.vue';
import DatatableOrderHistory from './DatatableOrderHistory.vue';
import {
    shipped
} from '../../../data/orderHistory'
export default {
    components: {
        NewOrders,
        ShippedOrders,
        CancelledOrders,
        DatatableOrderHistory
    },
    name: 'orderHistory',
    data() {
        return {
            data: JSON.parse(JSON.stringify(shipped)),
            data2: JSON.parse(JSON.stringify(shipped)),
            data3: JSON.parse(JSON.stringify(shipped))
        }
    },
    methods: {
        getImageUrl(path) {
            return require("@/assets/images/ecommerce/" + path);
        },
        remove(item) {
            this.data.splice(item, 1)
        },
        remove2(item) {
            this.data2.splice(item, 1)
        },
        remove3(item) {
            this.data3.splice(item, 1)
        }
    }
}
</script>
