<template>
     <div class="col-md-6 text-start">
                <div class="card">
                    <div class="card-header">
                      <h5 class="card-title">Toaster With Icon</h5>
                    </div>
                    <div class="card-body btn-showcase">
                      
                      <button class="btn btn-success " type="button" @click="success_with_icon" variant="success">Success</button>
                      
                      <button class="btn btn-info " type="button" @click="info_with_icon" variant="info">Info</button>

                      <button class="btn btn-danger " type="button" @click="error_with_icon" variant="danger">Error</button>

                      <button class="btn btn-info " type="button" @click="info_with_cancle" variant="info">Cancle</button>

                    </div>
                </div>
              </div>
</template>
<script>
import { useToast } from "vue-toastification";
export default {
    methods:{
         success_with_icon() {
          useToast().success(" New order has been placed ",{icon: 'fa fa-check'})
      },
      info_with_icon() {
        useToast().info(" New order has been placed ",{icon: 'fa fa-check'})
      },
      error_with_icon() {
        useToast().error(" New order has been placed ",{icon: 'fa fa-times'})
      },
       info_with_cancle() {
        this.$toast.show(' New order has been placed ', { theme: 'outline',position: 'bottom-right', closeOnSwipe: true, type: 'default', duration: 2000, });
      }
    }
}
</script>