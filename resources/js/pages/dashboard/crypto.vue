<template>
<Breadcrumbs main="Dashboard" title="Crypto" />
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-3 col-xl-4 box-col-4">
            <div class="row">
                <WelcomeCard />
                <AverageSalesCard />
                <AverageProfitCard />
                <AverageVisitsCard />
                <TransactionsCard />
            </div>
        </div>
        <div class="col-xxl-6 col-xl-8 box-col-8e">
            <div class="row">
                <BitcoinEthreumLeaveCard />
                <MarketGraphCard />
                <MyCurrenciesCard />
                <BuyCoinsCard />
                <SellCoinsCard />
            </div>
        </div>
        <div class="col-xxl-3 box-col-12">
            <div class="row box-order">
                <YourBalanceCard />
                <MyPortfolioCard />
                <ActivitiesCard />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import WelcomeCard from "./crypto/WelcomeCard.vue";
import AverageSalesCard from "./crypto/AverageSalesCard.vue";
import AverageProfitCard from "./crypto/AverageProfitCard.vue";
import AverageVisitsCard from "./crypto/AverageVisitsCard.vue";
import TransactionsCard from "./crypto/TransactionsCard.vue";
import BitcoinEthreumLeaveCard from "./crypto/BitcoinEthreumLeaveCard.vue";
import MarketGraphCard from "./crypto/MarketGraphCard.vue";
import MyCurrenciesCard from "./crypto/MyCurrenciesCard.vue";
import BuyCoinsCard from "./crypto/BuyCoinsCard.vue";
import SellCoinsCard from "./crypto/SellCoinsCard.vue";
import YourBalanceCard from "./crypto/YourBalanceCard .vue";
import MyPortfolioCard from "./crypto/MyPortfolioCard.vue";
import ActivitiesCard from "./crypto/ActivitiesCard.vue";
import {
    cryptoDashboard
} from "../../data/comon";
export default {
    components: {
        WelcomeCard,
        AverageSalesCard,
        AverageProfitCard,
        AverageVisitsCard,
        TransactionsCard,
        BitcoinEthreumLeaveCard,
        MarketGraphCard,
        MyCurrenciesCard,
        BuyCoinsCard,
        SellCoinsCard,
        YourBalanceCard,
        MyPortfolioCard,
        ActivitiesCard

    },
    data() {
        return {
            cryptoDashboard: cryptoDashboard,
        };
    },
};
</script>
