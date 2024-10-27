<template>
  <Breadcrumbs main="Ecommerce" title="Paymen Details" />

  <div class="container-fluid credit-card">
    <div class="row">

      <CreditCard />

      <DebitCard />

      <COD />

      <EMI />

      <NetBanking />

    </div>
  </div>
</template>
<script>
import CreditCard from './CreditCard.vue';
import DebitCard from './DebitCard.vue';
import COD from './COD.vue';
import EMI from './EMI.vue';
import NetBanking from './NetBanking.vue';
export default {
  name: 'paymentDetails',
  components: {
    CreditCard,
    DebitCard,
    COD,
    EMI,
    NetBanking
  }
}
</script>