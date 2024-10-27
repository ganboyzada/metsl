<template>
    <div>
        <Breadcrumbs main="UI Kits" title="Tag & Pills" />

        <div class="container-fluid">
            <div class="row tag-pills">
                <ContextualVariations />
                <TagsWithNumber />
                <PillsWithNumber />
                <TagsWithIcon />
                <PillsWithIcon />
                <BadgesExample />
                <BadgesAsPartButtons />
            </div>
        </div>
    </div>
</template>

<script>
import ContextualVariations from "./tag_pills/ContextualVariations.vue";
import TagsWithNumber from "./tag_pills/TagsWithNumber.vue";
import PillsWithNumber from "./tag_pills/PillsWithNumber.vue";
import TagsWithIcon from "./tag_pills/TagsWithIcon.vue";
import PillsWithIcon from "./tag_pills/PillsWithIcon.vue";
import BadgesExample from "./tag_pills/BadgesExample.vue";
import BadgesAsPartButtons from "./tag_pills/BadgesAsPartButtons.vue";

export default {
    components: {
        ContextualVariations,
        TagsWithNumber,
        PillsWithNumber,
        TagsWithIcon,
        PillsWithIcon,
        BadgesExample,
        BadgesAsPartButtons,
    },
};
</script>
