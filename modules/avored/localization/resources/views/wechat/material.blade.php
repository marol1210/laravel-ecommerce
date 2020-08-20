@extends('avored::layouts.app')

@section('page_title')
    <div class="text-gray-800 flex items-center">
        <div class="text-xl text-red-700 font-semibold">
            素材设置
        </div>
    </div>
@endsection

@section('content')
<el-row>
    <el-col span="8">
    	<sys_tab></sys_tab>
    </el-col>
</el-row>
@endsection

@push('scripts')
<template id="sys_tab">
    <el-tabs tab-position="left">
        <el-tab-pane label="{{__('文本')}}">
            	<el-form label-position="right" label-width="80px" >
                  <el-form-item label="标题">
                    <el-input></el-input>
                  </el-form-item>
                  <el-form-item label="内容">
                    <el-input type="textarea" rows="10" v-model="message"></el-input>
                  </el-form-item>
           		  <el-form-item>
                    <el-button type="primary" size="small" @click="submit">提交</el-button>
                  </el-form-item>
                </el-form>
        </el-tab-pane>
        
        <el-tab-pane label="{{__('单图文')}}">
        	<el-form label-position="right" label-width="80px" >
              <el-form-item label="关键字">
                    <el-tag
                    :key="tag"
                    v-for="tag in dynamicTags"
                    closable
                    :disable-transitions="false"
                    @close="handleClose(tag)"
                  	>
                   	 @{{tag}}
                    </el-tag>
                  
                    <el-input
                      class="input-new-tag"
                      v-if="inputVisible"
                      v-model="inputValue"
                      ref="saveTagInput"
                      size="small"
                      @keyup.enter.native="handleInputConfirm"
                      @blur="handleInputConfirm"
                    >
                    </el-input>
                    <el-button v-else class="button-new-tag" size="small" @click="showInput">+ 新建关键字</el-button>
              </el-form-item>
              <el-form-item label="内容">
                <el-input type="textarea" v-model="message"></el-input>
              </el-form-item>
 		 	  <el-form-item>
                <el-button type="primary" size="small" @click="submit">提交</el-button>
              </el-form-item>
            </el-form>
		</el-tab-pane>
        <el-tab-pane label="{{__('多图文')}}">
        </el-tab-pane>
    </el-tabs>
</template>
<script>
	var templates = document.getElementById('sys_tab').innerHTML;
	Vue.component('sys_tab',{
          data: function () {
              return {
                  dynamicTags: [],
                  message: '',
                  inputVisible: false,
                  inputValue: ''
                };
          },
          methods: {
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

              submit() {
                  	$this = this;
					axios.post("{{route('material.store')}}", {
						
					  })
					  .then(function (response) {
					  })
				  .catch(function (error) {
					  for(var m in error.response.data.errors){
						  alert(m+':'+error.response.data.errors[m][0]);
					  }
				  });
              }
            },
          template: templates
     });
</script>
@endpush
<style>
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
</style>