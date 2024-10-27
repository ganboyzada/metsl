<template>
    <Breadcrumbs title="Basic table" main="Bootstrap Table" />
    <div class="container-fluid basic_table">
            <div class="row">
            <basicTable/>
            <inverseTable/>
            <hoverableRows/>
            <backgroundUtilities/>
            <tableHead/>
            <stripedRow/>
      
            </div>
            </div>
</template>
<script>
import basicTable from "./basicTable.vue"
import inverseTable from "./inverseTable.vue"
import hoverableRows from "./hoverableRows.vue"
import backgroundUtilities from "./backgroundUtilities.vue"
import tableHead from "./tableHead.vue"
import stripedRow from "./stripedRow.vue"

export default {
    components:{
        basicTable,
        inverseTable,
        hoverableRows,
        backgroundUtilities,
        tableHead,
        stripedRow,
       
    }
}
</script>