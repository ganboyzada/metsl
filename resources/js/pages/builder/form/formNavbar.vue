<template>
    <nav class="navbar navbar-expand-md p-0">
        <form class="form-inline" @submit.prevent="">
            <div class="me-2">
                <select class="btn form-control b-light" id="n-columns" @change="change($event)">
                    <option value="1">1 Column</option>
                    <option value="2">2 Columns</option>
                </select>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Copy HTML</button>
        </form>
    </nav>
</template>

<script>
import {
    VueDraggableNext
} from 'vue-draggable-next'

export default {
    data() {
        return {
            display: false,
            show: 1,
            text: '',

        }
    },
    components: {
        draggable: VueDraggableNext,
    },
    methods: {
        change(e) {
            this.show = e.target.value
        },
        finish(e) {
            var a = document.getElementById(e.item.id)
            if (document.getElementById(e.item) == null) {
                a[0].append(document.getElementById('add').outerHTML)

            }
            if (document.getElementById('formhtml') === null) {
                this.text = ''
            } else {
                document.getElementById('formhtml').innerHTML = document.getElementById('formhtml').outerHTML
                this.text = document.getElementById('formhtml').innerHTML
            }
        },

    }
}
</script>