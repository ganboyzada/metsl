<template>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label>Enter some Details</label>
                <textarea class="form-control" id="exampleFormControlTextarea4" rows="3"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label>Upload project file</label>
                <DropZone class="text-center" :maxFileSize="Number(60000000)" url="http://localhost:8080"
                    :uploadOnDrop="true" :multipleUpload="true" :parallelUpload="2" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="text-end"><a class="btn btn-success me-3" href="javascript:void(0)">Add</a><a class="btn btn-danger"
                    href="javascript:void(0)">Cancel</a></div>
        </div>
    </div>
</template>

<script>
import Datepicker1 from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
    name: 'createProject',
    components: {
        Datepicker1
    },
}
</script>
