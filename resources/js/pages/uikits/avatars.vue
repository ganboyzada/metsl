<template>
  <div>
    <Breadcrumbs main="UI Kits" title="avatars" />

    <div class="container-fluid">
      <div class="user-profile">
        <div class="row">
          <Sizing />
          <StatusIndicator />
          <Initials />
          <Shape />
          <Ratio />
          <Groups />
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import Sizing from './avatars/Sizing.vue';
import StatusIndicator from './avatars/StatusIndicator.vue';
import Initials from './avatars/Initials.vue';
import Shape from './avatars/Shape.vue';
import Ratio from './avatars/Ratio.vue';
import Groups from './avatars/Groups.vue';
export default {
  components: {
    Sizing,
    StatusIndicator,
    Initials,
    Shape,
    Ratio,
    Groups
  }
};
</script>