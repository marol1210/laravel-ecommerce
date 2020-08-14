<?php

namespace AvoRed\Localization\Providers;

use Illuminate\Support\ServiceProvider;


class WechatProvider extends ServiceProvider
{
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('wechat',function($app){
            return new \AvoRed\Localization\Logic\Wechat();
        });
        
        $this->app->alias('wechat', \AvoRed\Localization\Logic\Wechat::class);
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
