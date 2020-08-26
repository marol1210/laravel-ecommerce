@extends('avored::layouts.app')
@section('meta_title')
    AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    <div class="text-gray-800 flex items-center">
        <div class="text-xl text-red-700 font-semibold">
             	{{__('system.admin_menus.wechat')}}
        </div>
        {{-- <div class="ml-auto">
            <a href="{{ route('admin.currency.create') }}"
                class="px-4 py-2 font-semibold leading-7 text-white hover:text-white bg-red-600 rounded hover:bg-red-700"
            >
                <svg class="w-5 h-5 inline-block text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 11a1 1 0 0 1 0 2h-4v4a1 1 0 0 1-2 0v-4H7a1 1 0 0 1 0-2h4V7a1 1 0 0 1 2 0v4h4z"/>
                </svg>
                {{ __('avored::system.btn.create') }}
            </a>
        </div> --}}
    </div>
@endsection
@section('content')
<div class="flex items-center">

    <div class="p-5 w-full block border">
    
        <table width="90%" frame="border" border="10px">
        	<tr>
        		<th>授权时间</th>
        		<th>授权appid</th>
        		<th>授权者</th>
        		<th width="30%">授予权限</th>
        	</tr>
        	
        	@foreach($wechat as $k=>$row)
        	<tr>
        		<td>{{ $row['updated_at'] }}</td>
        		<td>{{ $row['authorizer_appid'] }}</td>
        		<td>{{ $row['openid'] }}
        			<img src=""/>
        		</td>
        		<td>
        			@php
        				$v = json_decode($row['func_info'],true);
						$ids = collect($v)->flatten()->reject(function ($value, $key) {
                            return empty($value);
                        });
        				$config = config('wechat.authority_set.official');
        			@endphp
        			
        			<div class='set'>
        			【
    				@foreach($ids as $aa=>$id)
    					@php
    						$entry = explode('@',$config[$id]);
    					@endphp
    					<b title="{{$entry[1]}}" style="display: inline-block;">{{$entry[0]}}@if(!$loop->last) 、  @endif</b>
    				@endforeach
    				】
    				</div>
        		</td>
        	</tr>
        	@endforeach
        </table>
    </div>
</div>

<el-tabs type="border-card" tab-position="left">
  <el-tab-pane label="添加关注回复">添加关注回复</el-tab-pane>
  <el-tab-pane label="添加关键字">配置管理</el-tab-pane>
</el-tabs>
@endsection
<style>
    tr .set {
        color: #0f63cc;
        cursor: help;
    }
</style>