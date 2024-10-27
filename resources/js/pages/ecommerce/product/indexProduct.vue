<template>
    <Breadcrumbs main="Ecommerce" title="Product" />

    <topPage />
</template>

<script>
import topPage from './toppage.vue'

export default {
    name: 'indexProduct',
    components: {
        topPage
    }
}
</script>
