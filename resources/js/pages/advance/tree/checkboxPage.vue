<template>
    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Checkbox Tree</h5>
            </div>
            <div class="card-body">
                <div id="treecheckbox">
                    <Tree :nodes="menu" :use-icon="false" :use-checkbox="true" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import treeView from "@/mixins/treeView"
import Tree from "vue3-tree";
import "vue3-tree/dist/style.css"
export default {
    components: {
        Tree
    },
    mixins: [treeView],

}
</script>
