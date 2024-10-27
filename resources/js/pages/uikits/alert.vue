<template>
  <div>
    <Breadcrumbs main="UI Kits" title="alert" />

    <div class="container-fluid">
      <div class="row">
        <ThemeColorAlerts />
        <LinkColorinTheme />
        <Dismissing />
        <AlertWithIcon />
        <LightAlerts />
        <LinkColor />
        <Dismissing1 />
        <OutlineAlerts />
        <OutlineDarkAlerts />
        <AlertWithIconoutline />
        <AlertWithIconinverse />
        <TextAsAction />
        <AdditionalContent />
      </div>
    </div>
  </div>
</template>

<script>
import ThemeColorAlerts from "./alert/ThemeColorAlerts.vue"
import LinkColorinTheme from "./alert/LinkColorinTheme-color.vue"
import Dismissing from "./alert/Dismissing.vue";
import AlertWithIcon from "./alert/AlertWithIcon.vue";
import LightAlerts from "./alert/LightAlerts.vue";
import LinkColor from "./alert/LinkColor.vue";
import Dismissing1 from "./alert/Dismissing1.vue";
import OutlineAlerts from "./alert/OutlineAlerts.vue";
import OutlineDarkAlerts from "./alert/OutlineDarkAlerts.vue";
import AlertWithIconoutline from "./alert/AlertWithIconoutline.vue";
import AlertWithIconinverse from "./alert/AlertWithIconinverse.vue";
import TextAsAction from "./alert/TextAsAction.vue";
import AdditionalContent from "./alert/AdditionalContent.vue";
export default {
  components: {
    ThemeColorAlerts,
    LinkColorinTheme,
    Dismissing,
    AlertWithIcon,
    LightAlerts,
    LinkColor,
    Dismissing1,
    OutlineAlerts,
    OutlineDarkAlerts,
    AlertWithIconoutline,
    AlertWithIconinverse,
    TextAsAction,
    AdditionalContent
  },
  data() {
    return {
      primary: true,
      secondary: true,
      success: true,
      info: true,
      warning: true,
      danger: true,
      light: true,
      dark: true,
    };
  }
};
</script>