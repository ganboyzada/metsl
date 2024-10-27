<template>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h5>Check Box button group</h5><span>Add <code>.active</code> for active state and <code>.disabled</code> class or <code>disabled="disabled"</code> attribute</span>
        </div>
        <div class="card-body btn-group-showcase">
            <div class="row">
                <div class="col-xl-6 col-sm-12">
                    <div class="btn-group btn-option" data-bs-toggle="buttons">
                        <div class="btn btn-primary">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-primary-1" type="checkbox">
                                <label for="checkbox-primary-1">Option 1</label>
                            </div>
                        </div>
                        <div class="btn btn-primary">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-primary-2" type="checkbox">
                                <label for="checkbox-primary-2">Option 2</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12">
                    <div class="btn-group btn-option" data-bs-toggle="buttons">
                        <div class="btn btn-secondary">
                            <div class="checkbox checkbox-secondary">
                                <input id="checkbox-primary-3" type="checkbox">
                                <label for="checkbox-primary-3">Option 1</label>
                            </div>
                        </div>
                        <div class="btn btn-secondary">
                            <div class="checkbox checkbox-secondary">
                                <input id="checkbox-primary-4" type="checkbox">
                                <label for="checkbox-primary-4">Option 2</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12">
                    <div class="btn-group btn-option" data-bs-toggle="buttons">
                        <div class="btn btn-success">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox-primary-5" type="checkbox">
                                <label for="checkbox-primary-5">Option 1</label>
                            </div>
                        </div>
                        <div class="btn btn-success">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox-primary-6" type="checkbox">
                                <label for="checkbox-primary-6">Option 2</label>
                            </div>
                        </div>
                    </div>
                </div>
                <checkBox2 />
                <div class="col-xl-6 col-sm-12 button-group-mb-sm">
                    <div class="btn-group btn-option" data-bs-toggle="buttons">
                        <div class="btn btn-light txt-dark">
                            <div class="checkbox checkbox-light">
                                <input id="checkbox-light-13" type="checkbox">
                                <label for="checkbox-light-13">Option 1</label>
                            </div>
                        </div>
                        <div class="btn btn-light txt-dark">
                            <div class="checkbox checkbox-light">
                                <input id="checkbox-light-14" type="checkbox">
                                <label for="checkbox-light-14">Option 2</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import checkBox2 from './checkBox2.vue'
export default {
    components:{
        checkBox2
    }
}
</script>
