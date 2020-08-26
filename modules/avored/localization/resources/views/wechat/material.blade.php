@extends('avored::layouts.app')

@section('page_title')
    <div class="text-gray-800 flex items-center">
        <div class="text-xl text-red-700 font-semibold">
            素材设置
        </div>
    </div>
@endsection

@section('content')
<el-row :gutter="24">
    <el-col>
    	<sys_tab></sys_tab>
    </el-col>
</el-row>
@endsection

@push('scripts')
<template id="sys_tab">
    <el-tabs tab-position="left" @tab-click="changeType">
        <el-tab-pane label="{{__('文本')}}">
        	<el-col :span="8">
            	<el-form label-position="right" label-width="80px" >
                  <el-form-item label="标题">
                    <el-input v-model="title"></el-input>
                  </el-form-item>
                  <el-form-item label="内容">
                    <el-input type="textarea" rows="10" v-model="message"></el-input>
                  </el-form-item>
           		  <el-form-item>
                    <el-button type="primary" size="small" @click="submit">提交</el-button>
                  </el-form-item>
                </el-form>
            </el-col>
            
            <el-col :span="14">
            	<el-card class="box-card" shadow="never">
            	  <div slot="header" class="clearfix" style="font-size: larger;font-weight: bold;">
                    <span>{{__('现有文本')}}</span>
                  </div>
                  
                <el-collapse>
                	@php
                		$list = \App\Material::where('create_user_id',auth()->id())->get()->toArray();
                	@endphp
        			@foreach($list as $k=>$c)
                      <el-collapse-item  name="{{$k}}" title="{{$c['title']}}">
                        <div>{{ json_decode($c['content'],true)['content'] }}</div>
                      </el-collapse-item>
        			@endforeach
                </el-collapse>
                </el-card>
        	</el-col>
        </el-tab-pane>
        
        <el-tab-pane label="{{__('图文')}}"  @tab-click="changeType">
           	 <el-form label-position="right" label-width="50px" >
           	   <el-form-item label="">
            	<div class="wechat_msg" style="width:360px">
            		<div class="head"  @click="headImage">
            		    <el-avatar style="width:360px;height:200px;" shape="square">
                          <img src=""/>
                        </el-avatar>
            		</div>
            		<div class="child"><input style="border:1px solid black;" placeholder="标题"/></div>
            		<div class="child">
            		  <el-input placeholder="请输入标题">
                        <el-button slot="append" icon="el-icon-picture-outline"></el-button>
                      </el-input>
            		</div>
            		<div class="child">
            		  <el-input placeholder="请输入标题">
                        <template slot="append"><el-button slot="append" icon="el-icon-picture-outline"></el-button></template>
                      </el-input>
            		</div>
            		<div class="child">
            		  <el-input placeholder="请输入标题">
                        <template slot="append"><el-button slot="append" icon="el-icon-picture-outline"></el-button></template>
                      </el-input>
            		</div>
            		<div class="child">
            		  <el-input placeholder="请输入标题">
                        <template slot="append"><el-button slot="append" icon="el-icon-picture-outline"></el-button></template>
                      </el-input>
            		</div>
            		<div class="child">
            		  <el-input placeholder="请输入标题">
                        <template slot="append"><el-button slot="append" icon="el-icon-picture-outline"></el-button></template>
                      </el-input>
            		</div>
            		<div class="child">
            		  <el-input placeholder="请输入标题">
                        <template slot="append"><el-button slot="append" icon="el-icon-picture-outline">80*80</el-button></template>
                      </el-input>
            		</div>
            		<div class="child">
            		  <el-input placeholder="请输入标题">
                        <template slot="append"><el-button slot="append" icon="el-icon-picture-outline">80*80</el-button></template>
                      </el-input>
            		</div>
            	</div>
               </el-form-item>
               <el-form-item>
                <el-button type="primary" size="small" @click="submit">提交</el-button>
               </el-form-item>
        	 </el-form>
		</el-tab-pane>
    </el-tabs>
</template>
<script>
	var templates = document.getElementById('sys_tab').innerHTML;
	Vue.component('sys_tab',{
          data: function () {
              return {
                  news: {},
                  title:'',
                  message: '',
                  inputVisible: false,
                  inputValue: '',
                  type:'text'
                };
          },
          computed: {
        	  keyword: {
        	    // getter
        	    get: function () {
        	      return {content:this.message , type:this.type, title: this.title};
        	    },
        	  },
        	  news: {

        	  }
    	  },
          methods: {
              	headImage(){
					alert('@@');
              	},
        	    changeType(event) {
					switch(+event.index){
						case 1:
							this.type='news';
							break;
					}
        	    },
				submit() {
                    if(this.type == 'text'){
                    	$content = this.keyword;
                    }else if(this.type == 'news'){
                    	$content = this.keyword;
                    }else{
                        alert('errors!!!!');
						return;
                    }
                    axios.post("{{route('material.store')}}", $content)
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
    .wechat_msg > div img {
        width:100%;
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
  
.wechat_msg > div.head + div.child {
    position: absolute;
    top: 158px;
    opacity: .5;
    width: 360px;
}

.wechat_msg > div.head + div.child input:first-child {
    width:360px;
}
.wechat_msg input , .wechat_msg .el-input-group__append{
    border-radius: 0px;
}
</style>