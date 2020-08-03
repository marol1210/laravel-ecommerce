@extends('avored::layouts.app')

@section('meta_title')
    {{ __('avored::system.admin-user.create.title') }}: AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    {{ __('avored::system.admin-user.create.title') }}
@endsection

@section('content')
<a-row type="flex" justify="center">
    <a-col :span="24">
        <admin-user-save base-url="{{ asset(config('avored.admin_url')) }}" inline-template>
        <div>
            <a-form 
                :form="adminUserForm"
                method="post"
                action="{{ route('admin.admin-user.store') }}"                    
                @submit="handleSubmit"
            >
                @csrf

                <a-tabs tabbar-gutter="15" tab-position="left" default-active-key="user.admin-user.info">
                @foreach ($tabs as $tab)
                    <a-tab-pane :force-render="true" tab="{{ $tab->label() }}" key="{{ $tab->key() }}">
                        @php
                            $path = $tab->view();
                        @endphp
                        @include($path)
                    </a-tab-pane>
                @endforeach
                </a-tabs>
                
                <a-form-item>
                    <a-button
                        type="primary"
                        html-type="submit"
                    >
                        {{ __('avored::system.btn.save') }}
                    </a-button>
                    
                    <a-button
                        class="ml-1"
                        type="default"
                        v-on:click.prevent="cancelAdminUser"
                    >
                        {{ __('avored::system.btn.cancel') }}
                    </a-button>
                </a-form-item>
            </a-form>
            </div>
        </language-save>
    </a-col>
</a-row>
@endsection
