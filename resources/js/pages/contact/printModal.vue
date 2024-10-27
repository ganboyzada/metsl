<template>
<div class="modal fade modal-bookmark" id="printModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Print preview</h3>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body list-persons">
                <div class="profile-mail pt-0" id="DivIdToPrint">
                    <div class="d-flex">
                        <img class="img-100 img-fluid m-r-20 rounded-circle" id="updateimg" :src="getImageUrl(selectedUser.img)" alt="">
                        <div class="flex-grow-1 mt-0">
                            <h4><span id="printname">{{selectedUser.name}} </span><span id="printlast">{{selectedUser.lastName}}</span></h4>
                            <p id="printmail">{{selectedUser.email}}</p>
                        </div>
                    </div>
                    <div class="email-general">
                        <h4>General</h4>
                        <p>Email Address: <span class="font-primary" id="mailadd">{{selectedUser.email}} </span></p>
                    </div>
                </div>
                <button class="btn btn-secondary" id="btnPrint" type="button" onclick="printDiv();">Print</button>
                <button class="btn btn-primary ms-2" type="button" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import getImage from '@/mixins/getImage'
import {
    mapGetters
} from 'vuex'
export default {

    mixins: [getImage],
    computed: {
        ...mapGetters({
            selectedUser: 'contact/selectedUser'
        })
    },

}
</script>
