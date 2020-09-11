<template>
  	<el-col>
		<el-form label-position="right" label-width="30px" >
	        <el-form-item label="">
	            <el-tag
	            v-for="(tag,index) of dynamicTags"
	            closable
	            :disable-transitions="false"
	            @close="handleClose(tag)"
	          	>
	           	 {{tag}}
	            </el-tag>
	          
	            <el-input
	              class="input-new-tag custom-el-button"
	              v-show="inputVisible"
	              v-model="inputValue"
	              ref="saveTagInput"
	              size="small"
	              @keyup.enter.native="handleInputConfirm"
	              @blur="handleInputConfirm"
	            >
	            </el-input>
	            <el-button v-show="inputVisible===false" class="button-new-tag custom-el-button" :class="{'is-disabled':(dynamicTags.length>=8)}" ref="btn_add" size="small" @click="showInput">+ 新建关键字</el-button>
	        </el-form-item>
	        
	        
	        <el-form-item label="">
	           <el-input type="textarea" v-model="message" rows="10" maxlength="200"  show-word-limit></el-input>
	        </el-form-item>
      </el-form>
    </el-col>
</template>


<script>
export default {
      data: function () {
          return {
            dynamicTags: [],
            message: '',
            inputVisible: false,
            inputValue: '',
            id: '',
            maxAmount: 8
          };
      },
      methods: {
          clean:function(){
              this.dynamicTags = [];
              this.message = '';
              this.id = null;
          },
          handleClose(tag) {
            this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
            if(this.dynamicTags.length<8){
             this.$refs.btn_add.$vnode.elm.disabled = false;
             this.$refs.btn_add.$vnode.elm.innerText = '+ 新建关键字';
            }
          },

          showInput() {
            this.inputVisible = true;
            this.$nextTick(_ => {
              this.$refs.saveTagInput.$refs.input.focus();
            });
          },

          handleInputConfirm() {
            let inputValue = this.inputValue;
            if (inputValue) {
              this.dynamicTags.push(inputValue);
            }

            this.inputVisible = false;
            this.inputValue = '';


            if(this.dynamicTags.length>=8){
             this.$refs.btn_add.$vnode.elm.innerText = '关键字数已达上限';
             this.$refs.btn_add.$vnode.elm.disabled = true;
            }
          }
	   }
 }
</script>

<style>

.el-form-item__content {
  line-height:unset;
}
</style>

<style scoped>
  .el-tag + .el-tag {
    margin-left: 10px;
  }
  
  .button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
  }

  .input-new-tag {
    width: 90px !important;
    margin-left: 10px;
    vertical-align: bottom;
  }
  
  .infinite-list-wrapper{
    height:280px;
  }
  
  .custom-el-button{
	 margin-left:0px;
  	border-radius: 0px;
  }
</style>