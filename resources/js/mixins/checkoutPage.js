import { mapState } from 'vuex';
export default {
    data() {
        return {
          activeAmount: "0",
          totalAmount: 0,
          isLogin: false,
          user: {
            firstName: { value: '', errormsg: '' },
            lastName: { value: '', errormsg: '' },
            phone: { value: '', errormsg: '' },
            email: { value: '', errormsg: '' },
            address: { value: '', errormsg: '' },
            city: { value: '', errormsg: '' },
            state: { value: '', errormsg: '' },
            pincode: { value: '', errormsg: '' }
          },
          submitted: false,
          payment: false,
          complete: false,
          selectedPayment: 'stripe'
        }
      },
    created() {
   
        this.activeAmount = 60;},
      
            computed: {
          ...mapState({
            cart: state => state.product.cart,
            getAmount() {
              return (this.totalAmount = this.$store.getters[
                'product/getTotalAmount'
                ]);
            }}),
         },
       methods: {
        onSubmit() {
    
    if (this.user.firstName.value.length <= 1 || this.user.firstName.value.length > 10) {
      this.user.firstName.errormsg = 'empty not allowed'
    } else {
      this.user.firstName.errormsg = ''
    }
    
    if (this.user.lastName.value.length <= 1 || this.user.lastName.value.length > 10) {
      this.user.lastName.errormsg = 'empty not allowed'
    } else {
      this.user.lastName.errormsg = ''
    }
    
    if (this.user.city.value.length < 3 || this.user.city.value.length > 10) {
      this.user.city.errormsg = 'empty not allowed'
    } else {
      this.user.city.errormsg = ''
    }
    if (this.user.pincode.value.length < 4) {
    
      this.user.pincode.errormsg = 'empty not  allowed'
    } else {
      this.user.pincode.errormsg = ''
    }
    if (!this.user.state.value) {
      this.user.state.errormsg = 'empty not allowed'
    } else {
      this.user.state.errormsg = ''
    }
    if (!this.user.phone.value) {
      this.user.phone.errormsg = 'empty not allowed'
    } else {
      this.user.phone.errormsg = ''
    }
    if (!this.user.address.value) {
      this.user.address.errormsg = 'empty not allowed'
    } else {
      this.user.address.errormsg = ''
    }
    if (!this.user.email.value) {
      this.user.email.errormsg = 'empty not allowed'
    } else if (!this.validEmail(this.user.email.value)) {
    
      this.user.email.errormsg = 'Valid email required.'
    
    } else {
      this.user.email.errormsg = ''
    }
    
    },
    validEmail: function (email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return re.test(email)
    },
    
          payWithStripe() {
            this.onSubmit()
           
         
          if (this.user.firstName.errormsg != '' && this.user.lastName.errormsg != '' && this.user.city.errormsg != '' && this.user.pincode.errormsg != '' && this.user.state.errormsg != '' && this.user.phone.errormsg != '' && this.user.address.errormsg != '' && this.user.email.errormsg != '') {
    
            this.onSubmit()
          }
          else  {
            this.payment=false
            var handler = (window).StripeCheckout.configure({
             
            });
            handler.open({
              name: 'Cuba ',
              description: 'Your Choice Theme',
              amount: this.totalAmount * 100
            });
          }},
    
          
      //    
        },
        mounted(){
          window.paypal.Buttons({
         
        }).render('#paypal-button-container')
        }
  }