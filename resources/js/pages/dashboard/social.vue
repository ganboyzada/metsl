<template>
<Breadcrumbs main="Dashboard" title="Social" />
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-3 col-ed-4 col-xl-4 box-col-4">
            <div class="row">
                <WelcomeCard />
                <MobileApplicationCard />
            </div>
        </div>
        <div class="col-xxl-6 col-ed-8 col-xl-8 box-col-8e">
            <div class="row">
                <FacebookCard />
                <InstagramCard />
                <TwitterCard />
                <InstagramSubscribersCard />
                <PhotoLinkClicksCard />
            </div>
        </div>
        <div class="col-xl-3 col-ed-none d-xxl-block d-lg-none box-col-none">
            <div class="row">
                <FollowerGenderCard />
                <FacebookCampaignCard />
            </div>
        </div>
        <AllCampaignsCard />
        <ViewsCard />
    </div>
</div>
</template>

<script>
import WelcomeCard from './social/WelcomeCard.vue';
import MobileApplicationCard from './social/MobileApplicationCard.vue';
import FacebookCard from './social/FacebookCard.vue';
import InstagramCard from './social/InstagramCard.vue';
import TwitterCard from './social/TwitterCard.vue';
import InstagramSubscribersCard from './social/InstagramSubscribersCard.vue';
import PhotoLinkClicksCard from './social/PhotoLinkClicksCard.vue';
import FollowerGenderCard from './social/FollowerGenderCard.vue';
import FacebookCampaignCard from './social/FacebookCampaignCard.vue';
import AllCampaignsCard from './social/AllCampaignsCard.vue';
import ViewsCard from './social/ViewsCard.vue';

export default {
    components: {
        WelcomeCard,
        MobileApplicationCard,
        FacebookCard,
        InstagramCard,
        TwitterCard,
        InstagramSubscribersCard,
        PhotoLinkClicksCard,
        FollowerGenderCard,
        FacebookCampaignCard,
        AllCampaignsCard,
        ViewsCard
    }
};
</script>
