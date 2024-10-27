<template>
    <div class="card" id="custom-state-button">
        <div class="card-header pb-0">
            <h3>Custom State Buttons</h3>
            <settingPage /><span>The <code>.btn</code> class used with <code>&lt;button&gt;</code>, <code>&lt;a&gt;</code>
                and <code>&lt;input&gt;</code> elements.</span>
        </div>
        <div class="card-body btn-showcase"><a class="btn btn-primary" href="javascript:void(0)" data-toggle="tooltip"
                title="btn btn-primary" role="button">Link</a>
            <input class="btn btn-secondary" type="button" value="Input" data-toggle="tooltip" title="btn btn-secondary">
            <input class="btn btn-success" type="submit" value="Submit" data-toggle="tooltip" title="btn btn-success">
            <button class="btn btn-info" type="submit" data-toggle="tooltip" title="btn btn-info">Button</button>

        </div>
    </div>
    <div class="card" id="outline-button">
        <div class="card-header pb-0">
            <h3>Outline Buttons</h3>
            <settingPage /><span>Add <code>.btn-outline-*</code> class for border button</span>
        </div>
        <div class="card-body btn-showcase">
            <button class="btn btn-outline-primary" type="button" title="btn btn-outline-primary">Primary Button</button>
            <button class="btn btn-outline-secondary" type="button" title="btn btn-outline-secondary">Secondary
                Button</button>
            <button class="btn btn-outline-success" type="button" title="btn btn-outline-success">Success Button</button>
            <button class="btn btn-outline-info" type="button" title="btn btn-outline-info">Info Button</button>
            <button class="btn btn-outline-warning" type="button" title="btn btn-outline-warning">Warning Button</button>
            <button class="btn btn-outline-danger" type="button" title="btn btn-outline-danger">Danger Button</button>
            <button class="btn btn-outline-light txt-dark" type="button" title="btn btn-outline-light">Light Button</button>

        </div>
    </div>
    <div class="card" id="outline-bold-button">
        <div class="card-header pb-0">
            <h3>Bold Border Outline Buttons</h3>
            <settingPage /> <span>Add <code>.btn-outline-*-2x</code> class for bold outline</span>
        </div>
        <div class="card-body btn-showcase">
            <button class="btn btn-outline-primary-2x" type="button" title="btn btn-outline-primary-2x">Primary
                Button</button>
            <button class="btn btn-outline-secondary-2x" type="button" title="btn btn-outline-secondary-2x">Secondary
                Button</button>
            <button class="btn btn-outline-success-2x" type="button" title="btn btn-outline-success-2x">Success
                Button</button>
            <button class="btn btn-outline-info-2x" type="button" title="btn btn-outline-info-2x">Info Button</button>
            <button class="btn btn-outline-warning-2x" type="button" title="btn btn-outline-warning-2x">Warning
                Button</button>
            <button class="btn btn-outline-danger-2x" type="button" title="btn btn-outline-danger-2x">Danger Button</button>
            <button class="btn btn-outline-light-2x txt-dark" type="button" title="btn btn-outline-light-2x">Light
                Button</button>

        </div>
    </div>
    <outlineButtons />
</template>

<script>
import { Tooltip } from 'bootstrap/dist/js/bootstrap.esm.min'
import outlineButtons from "./outlineButtons.vue"
export default {
    components: {
        outlineButtons
    },
    mounted() {
        new Tooltip(document.body, {
            selector: "[data-bs-toggle='tooltip']"
        })
    }
}
</script>
