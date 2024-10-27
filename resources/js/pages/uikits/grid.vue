<template>
  <div>
    <Breadcrumbs main="UI Kits" title="grid" />

    <div class="container-fluid">
      <div class="row">
        <GridOptions />
        <GridColumn />
        <SettingoneOlumnwidth />
        <Verticalalignment />
        <Horizontalalignment />
        <NestingColumn />
        <Order />
        <Offset />
      </div>
    </div>

  </div>
</template>

<script>
import GridOptions from "./grid/GridOptions.vue"
import GridColumn from "./grid/GridColumn.vue";
import SettingoneOlumnwidth from "./grid/Settingoneolumnwidth.vue";
import Verticalalignment from "./grid/Verticalalignment.vue";
import Horizontalalignment from "./grid/Horizontalalignment.vue";
import NestingColumn from "./grid/NestingColumn.vue";
import Order from "./grid/Order.vue";
import Offset from "./grid/Offset.vue";
export default {
  components: {
    GridOptions,
    GridColumn,
    SettingoneOlumnwidth,
    Verticalalignment,
    Horizontalalignment,
    NestingColumn,
    Order,
    Offset
  }

};
</script>