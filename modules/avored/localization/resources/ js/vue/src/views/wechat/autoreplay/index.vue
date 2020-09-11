<template>
	<el-tabs tab-position="left">
      <el-tab-pane label="关键字回复">
      	<el-col :span="8">
    			<el-form label-position="right" label-width="30px" >
                <el-form-item label="">
                      <el-tag
                      :key="tag"
                      v-for="tag in dynamicTags"
                      closable
                      :disable-transitions="false"
                      @close="handleClose(tag)"
                    	>
                     	 {{tag}}
                      </el-tag>
                    
                      <el-input
                        class="input-new-tag custom-el-button"
                        v-if="inputVisible"
                        v-model="inputValue"
                        ref="saveTagInput"
                        size="small"
                        @keyup.enter.native="handleInputConfirm"
                        @blur="handleInputConfirm"
                      >
                      </el-input>
                      <el-button v-else class="button-new-tag custom-el-button" size="small" @click="showInput">+ 选择关键字</el-button>
                </el-form-item>
                
                <el-form-item>
                  <el-button type="primary" size="small" @click="submit">提交</el-button>
                </el-form-item>
              </el-form>
          </el-col>
      </el-tab-pane>
      <el-tab-pane label="关注回复">
      </el-tab-pane>
  </el-tabs>
</template>


<script>
export default {
      data: function () {
          return {
              //普通文本
        	  dynamicTags: [],
              message: '',
              inputVisible: false,
              inputValue: '',
              type:'keyword',
              //素材文本
              data:[
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"},
	              {"appear_count":10,"name":"aaa","address":"dddddd"}
              ],
              loading: false
            };
      },
      computed: {
          noMore () {
            return this.data.length >= 20
          },
          disabled () {
            return this.loading || this.noMore
          }
      },
      methods: {
    	  load () {
    	        this.loading = true
    	        setTimeout(() => {
    	          this.data.push({"appear_count":10,"name":"aaa","address":"dddddd"});
    	          this.data.push({"appear_count":10,"name":"aaa","address":"dddddd"});
    	          this.data.push({"appear_count":10,"name":"aaa","address":"dddddd"});
    	          this.data.push({"appear_count":10,"name":"aaa","address":"dddddd"});
    	          this.loading = false
    	        }, 2000)
	      },
          
          handleClose(tag) {
            this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
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
          },
          handleDelete(index, row) {
              console.log(index, row);
          },
          submit() {
            	$this = this;
      				axios.post("{{route('keyword.store')}}", {
      				    keywords: $this.dynamicTags,
      				    message: $this.message,
      				    type:$this.type,
      				  })
      				  .then(function (response) {
      				  })
      			  .catch(function (error) {
      				  for(var m in error.response.data.errors){
      					  alert(m+':'+error.response.data.errors[m][0]);
      				  }
      			  });
          }
	   }
 }
</script>

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