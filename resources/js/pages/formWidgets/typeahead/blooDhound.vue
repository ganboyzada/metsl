<template>
    <div class="col-sm-12 col-md-6 ">
        <div class="card">
            <div class="card-header ">
                <h5>Bloodhound (Suggestion Engine)</h5><span>Bloodhound offers advanced functionalities such as prefetching
                    and backfilling with remote data.</span>
            </div>
            <div class="card-body">
                <div id="the-basics">
                    <form class="theme-form">
                        <div class="form-group">
                            <vue3-simple-typeahead :items="list" class="form-control typeahead form-control"
                                :placeholder="options.placeholder" @selectItem="selectItem" @onInput="onInput"
                                @onBlur="onBlur" :minInputLength="options.minInputLength" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
</template>

<script>
import typeaheadlist from "@/mixins/commen/typeaheadlist"
export default {
    mixins: [typeaheadlist],
    created() {
        this.listFiltered = this.list;
    },
    data() {
        return {
            options: {
                placeholder: 'States of USA',
                minInputLength: 1,
            },
            listFiltered: [],
        };
    },
    methods: {
        selectItem(item) {
            this.data.selection = item;
        },
        onInput(event) {

            this.listFiltered = event.items;
        },
        onBlur(event) {

            this.listFiltered = event.items;
        },
    },
};
</script>
