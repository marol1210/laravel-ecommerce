@extends('layouts.app')

@section('breadcrumb')
<a-breadcrumb style="margin: 16px 0">
    <a-breadcrumb-item>
      <a href="{{ route('home') }}" title="home">
        {{ __('Home') }}
      </a>
    </a-breadcrumb-item>
    <a-breadcrumb-item>
        {{ __('Register') }}
    </a-breadcrumb-item>
</a-breadcrumb>
@endsection

@section('content')
<marol-register inline-template>
    <div>
        <a-row type="flex" align="middle">
            <a-col :span="14">
                <a-row type="flex" align="middle" class="h-100 text-center">
                    <a-col :span="24">
                        
                    </a-col>
                </a-row>
            </a-col>
            <a-col :span="10">
                <a-row type="flex">
                <a-col :span="20" :offset="2">
                    <a-card title="{{__('Account Management')}}">
                        <a-form 
                        	:label-col="{span:6}" 
                        	:wrapper-col="{span:12}"
                            :form="form"
                            method="post"
                            action="{{ route('register') }}"
                            @submit="handleSubmit">
                            @csrf()
    			    		<a-form-item label="昵称" has-feedback>
    			    			<a-input 
    			    				name="name" 
    			    				v-decorator="['name',{rules:[{required:true,message:'请填写昵称'}]}]" 
    			    				placeholder="昵称"/>
    			    		</a-form-item>
    			    		<a-form-item label="邮箱">
    			    			<a-input 
    			    				name="email"
    			    				v-decorator="['email',{rules:[{type:'email',message:'无效的邮箱地址'},{required:true,message:'请输入邮箱'}]}]"
    			    				placeholder="邮箱name@example.com"
    			    				type="email"
    		    				>
    								<a-tooltip slot="prefix" title="邮箱将作为登录帐号">
    						          <a-icon type="info-circle" style="color:rgba(0,0,0,.2);"></a-icon>
    						        </a-tooltip>
    		    				</a-input>
    			    		</a-form-item>
    						<a-form-item  label="密码" has-feedback>
    							<a-input type="password" 
    								name="password"
    								v-decorator="['password',{rules:[{required:true,message:'密码不能为空'},{validator:changePassword}]}]"
    								placeholder="密码"
    								>
    								<a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)"></a-icon>
    							</a-input>
    						</a-form-item>
    						<a-form-item  label="确认密码" has-feedback>
    							<a-input type="password" 
    								name="password_confirmation"
    								v-decorator="
    								[
    									'confirm_password',
    										{
    											rules:[
    												{required:true,message:'密码不能为空'},
    												{validator:confirmPassword}
    											]
    										}
    								]"
    								placeholder="密码确认"
    							>
    							<a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)"></a-icon>
    							</a-input>
    						</a-form-item>
                            <a-form-item  :wrapper-col="{offset:6,span:18}">
                                <a-button
                                    type="primary"
                                    :loading="loadingSubmitBtn"
                                    html-type="submit"
                                >
                               		     确定
                                </a-button>
                            </a-form-item>
    			    	</a-form>
                    </a-card>
                </a-col>
                </a-row>
            </a-col>
        </a-row>
    </div>
</marol-register>
@endsection

<style>
.ant-card {
    position: relative;
    z-index: 1;
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
}

.ant-input-affix-wrapper .ant-input{
    min-height: 0 !important;
}
</style>