<template>
  <div>
    <Breadcrumbs main="UI Kits" title="Dropdown" />

    <div class="container-fluid">
      <div class="row">
        <BasicDropdown />
        <BasicColorDropdown />
        <DropdownSplitButton />
        <RoundedDropdown />
        <DropdownWithDivider />
        <DropdownWithHeader />
        <DropdownWithDisable />
        <DropdownWithDropUp />
      </div>
    </div>

  </div>
</template>

<script>
import BasicDropdown from "./dropdown/BasicDropdown.vue"
import BasicColorDropdown from "./dropdown/BasicColorDropdown.vue"
import DropdownSplitButton from "./dropdown/DropdownSplitButton.vue"
import RoundedDropdown from "./dropdown/RoundedDropdown.vue"
import DropdownWithDivider from "./dropdown/DropdownWithDivider.vue"
import DropdownWithHeader from "./dropdown/DropdownWithHeader.vue"
import DropdownWithDisable from "./dropdown/DropdownWithDisable.vue"
import DropdownWithDropUp from "./dropdown/DropdownWithDropUp.vue"
export default {
  components: {
    BasicDropdown,
    BasicColorDropdown,
    DropdownSplitButton,
    RoundedDropdown,
    DropdownWithDivider,
    DropdownWithHeader,
    DropdownWithDisable,
    DropdownWithDropUp

  }
};
</script>