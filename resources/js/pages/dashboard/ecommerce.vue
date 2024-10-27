<template>
<div>
    <Breadcrumbs main="Dashboard" title="e-commerce" />
    <div class="container-fluid">
        <div class="row size-column">
            <div class="col-xxl-10 col-md-12 box-col-8 grid-ed-12">
                <div class="row">
                    <AllFourDeatilsCard />
                    <ValuableCustomerCard />
                    <OrderthismonthCard />
                    <MonthlyProfitsCard />
                    <OrderOverviewCard />
                    <DiscoverProCard />
                    <VisitorsCard />
                    <RecetOrderCard />

                </div>
            </div>
            <div class="
            col-xxl-2 col-xl-3 col-md-4
            grid-ed-none
            box-col-4e
            d-xxl-block d-none
          ">
                <TopCategoriesCard />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import AllFourDeatilsCard from "./ecommerce/AllFourDeatilsCard.vue"
import ValuableCustomerCard from "./ecommerce/ValuableCustomerCard.vue"
import OrderthismonthCard from "./ecommerce/OrderthismonthCard.vue"
import MonthlyProfitsCard from "./ecommerce/MonthlyProfitsCard.vue"
import OrderOverviewCard from "./ecommerce/OrderOverviewCard.vue"
import DiscoverProCard from "./ecommerce/DiscoverProCard.vue"
import VisitorsCard from "./ecommerce/VisitorsCard.vue"
import RecetOrderCard from "./ecommerce/RecetOrderCard.vue"
import TopCategoriesCard from "./ecommerce/TopCategoriesCard.vue"
import {
    ecomDashboard
} from "../../data/comon";
export default {
    components: {
        AllFourDeatilsCard,
        ValuableCustomerCard,
        OrderthismonthCard,
        MonthlyProfitsCard,
        OrderOverviewCard,
        DiscoverProCard,
        VisitorsCard,
        RecetOrderCard,
        TopCategoriesCard,

    },
    data() {
        return {
            ecomDashboard: ecomDashboard,
        };
    },
};
</script>
