@extends('avored::layouts.app')

@section('meta_title')
    AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    <div class="text-gray-800 flex items-center">
        <div class="text-xl text-red-700 font-semibold">
            自动回复
        </div>
    </div>
@endsection

@section('content')
	@php
		$cache = cache()->get('keyword.'.auth()->id(),[]);
	@endphp
	
<el-row :gutter="24">
    <el-col>
        <sys_tab></sys_tab>
	</el-col>
</el-row>
@endsection

@push('scripts')
<template id="sys_tab">
    <el-tabs tab-position="left">
        <el-tab-pane label="{{__('关键字回复')}}">
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
                        <el-button v-else class="button-new-tag" size="small" @click="showInput">+ {{__('新建关键字')}}</el-button>
                  </el-form-item>
                  
                  
                  <el-form-item label="">
                   		<el-tabs type="border-card">
                   			<el-tab-pane label="{{__('普通文本')}}">
                                 <el-input type="textarea" v-model="message" rows="10" maxlength="200"  show-word-limit></el-input>
                   			</el-tab-pane>
                   			<el-tab-pane label="{{__('素材文本')}}">
                       			  <el-table
                       			  	 v-infinite-scroll="load" 
                       			  	 infinite-scroll-disabled="disabled" 
                       			 	 :data="data" style="width: 100%;height:250px;overflow:auto"
                       			  >
                       			     	<el-table-column
                                          label="出现次数"
                                          width="100">
                                          <template slot-scope="scope">
                                            <span style="margin-left: 10px">@{{ scope.row.appear_count }}</span>
                                          </template>
                                        </el-table-column>
                                        <el-table-column
                                          label="标题"
                                          width="200">
                                          <template slot-scope="scope">
                                            <el-popover trigger="hover" placement="top">
                                              <p>姓名: @{{ scope.row.name }}</p>
                                              <p>住址: @{{ scope.row.address }}</p>
                                              <div slot="reference" class="name-wrapper">
                                                <el-tag size="medium">@{{ scope.row.name }}</el-tag>
                                              </div>
                                            </el-popover>
                                          </template>
                                        </el-table-column>
                                        <el-table-column label="操作">
                                          <template slot-scope="scope">
                                            <el-button
                                              size="mini"
                                              type="danger"
                                              @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                                          </template>
                                        </el-table-column>
                       			</el-table>
                       			 <div style="font-size: xx-small;">
                                 <p v-if="loading">加载中...</p>
    							 <p v-else-if="noMore">没有更多了</p>
                                 <p v-else>&nbsp;</p>
                                 </div>
                   			</el-tab-pane>
                   			<el-tab-pane label="{{__('图文')}}">
                   			</el-tab-pane>
                   		</el-tabs>
                  </el-form-item>
                  <el-form-item>
                    <el-button type="primary" size="small" @click="submit">提交</el-button>
                  </el-form-item>
                </el-form>
            </el-col>
            
	
        	<el-col :span="14">
            	<el-card class="box-card" shadow="never">
            	  <div slot="header" class="clearfix" style="font-size: larger;font-weight: bold;">
                    <span>{{__('现有关键字')}}</span>
                  </div>
                <!-- 
                <el-collapse>
        			@foreach($cache as $k=>$c)
                      <el-collapse-item  name="{{$k}}">
                      	<template slot="title">
                      		@foreach($c['keywords'] as $kw)
                         	<el-tag>{{$kw}}</el-tag>
                         	@endforeach
                        </template>
                        <div>{{$c['message']}}</div>
                      </el-collapse-item>
        			@endforeach
                </el-collapse>
                 -->
                 <el-collapse>
            		@foreach($list as $k=>$c)
                      <el-collapse-item  name="{{$k}}">
                      	<template slot="title">
            			@foreach($c as $_c)
            			<el-tag>{{$_c->name}}</el-tag>
                      	@endforeach
                        </template>
                        <div>{{$_c->contents->content}}</div>
                      </el-collapse-item>
            		@endforeach
                </el-collapse>
                </el-card>
        	</el-col>
		</el-tab-pane>
        <el-tab-pane label="{{__('关注回复')}}">
        </el-tab-pane>
    </el-tabs>
</template>
<script>
	var templates = document.getElementById('sys_tab').innerHTML;
	Vue.component('sys_tab',{
          data: function () {
              return {
                  //普通文本
            	  dynamicTags: [],
                  message: '',
                  inputVisible: false,
                  inputValue: '',
                  type:'keyword',

                  //素材文本
                  data:[{"appear_count":10,"name":"aaa","address":"dddddd"},{"appear_count":10,"name":"aaa","address":"dddddd"},{"appear_count":10,"name":"aaa","address":"dddddd"},{"appear_count":10,"name":"aaa","address":"dddddd"},{"appear_count":10,"name":"aaa","address":"dddddd"},{"appear_count":10,"name":"aaa","address":"dddddd"},{"appear_count":10,"name":"aaa","address":"dddddd"}],
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
            },
          template: templates
     });
</script>
@endpush
<style>
.el-tabs--border-card>.el-tabs__content{
    height:300px;
}
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
</style>