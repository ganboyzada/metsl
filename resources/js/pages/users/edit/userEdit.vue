<template>
    <Breadcrumbs title="Edit Profile" main="Users" />
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <sidePage />
                <editProfile />
                <projects />
            </div>
        </div>
</div>
</template>
<script>
import sidePage from './sidePage.vue';
import projects from './projects.vue'
import editProfile from "./editProfile.vue"
export default {
    components: {
        sidePage,
        projects,
        editProfile
    }
}
</script>