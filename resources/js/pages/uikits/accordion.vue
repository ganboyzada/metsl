<template>
  <div>
    <Breadcrumbs main="UI Kits" title="Accordion" />

    <div class="container-fluid">
      <div class="row">
        <BasicAccordion />
        <AllCloseAccordion />
        <ColorAccordion />
        <AccordionWithcononTitle />
        <Accordionopencloseicon />
      </div>
    </div>

  </div>
</template>

<script>
import BasicAccordion from './accordion/BasicAccordion.vue';
import AllCloseAccordion from './accordion/AllCloseAccordion.vue';
import ColorAccordion from './accordion/ColorAccordion.vue';
import AccordionWithcononTitle from './accordion/AccordionWithcononTitle.vue';
import Accordionopencloseicon from './accordion/Accordionopencloseicon.vue';
export default {
  components: {
    BasicAccordion,
    AllCloseAccordion,
    ColorAccordion,
    AccordionWithcononTitle,
    Accordionopencloseicon
  }
};
</script>