<script>
export default {
  data () {
    return {
      form: this.$form.createForm(this),
      loadingSubmitBtn: false
    };
  },
  methods:{
      handleSubmit (e) {
	      this.loadingSubmitBtn = true;
	      this.form.validateFields((err, values) => {
	        if (err) {
	          this.loadingSubmitBtn = false;
	          e.preventDefault();
	        }
	      });
	    },
	 add() {
      const { form } = this;
      // can use data-binding to get
      const keys = form.getFieldValue('keys');
      const nextKeys = keys.concat(id++);
      // can use data-binding to set
      // important! notify form to detect changes
      form.setFieldsValue({
        keys: nextKeys,
      });
    },
  	changePassword:function(rule,value,callback){
  		if(value && this.confirmDity){
  			this.form.validateFields(['confirm_password'],{force:true});
  		}
  		return callback();
  	},
  	confirmPassword: function(rule,value,callback){
  		this.confirmDity = true;
  		if(value && value != this.form.getFieldValue('password')){
  			return callback('密码确认不一致.');
  		}
  		return callback();
  	}
  }
};
</script>
