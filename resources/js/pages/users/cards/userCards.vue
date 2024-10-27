<template>
    <Breadcrumbs title="User Cards" main="Users" />

    <div class="container-fluid ">
        <div class="row">
            <card1 />

        </div>
    </div>
</template>

<script>
import card1 from './card1.vue';

export default {
    name: 'userCards',
    components: {
        card1,
    }
}
</script>
