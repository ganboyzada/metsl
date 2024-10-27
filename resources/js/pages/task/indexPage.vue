<template>
    <Breadcrumbs title="Tasks" />

    <div class="container-fluid">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                <addTask />
            </div>
        </div>
    </div>
</template>

<script>
import addTask from './addTask.vue'
export default {
    components: {
        addTask
    },
}
</script>
