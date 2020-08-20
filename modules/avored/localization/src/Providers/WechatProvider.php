<?php

namespace AvoRed\Localization\Providers;

use Illuminate\Support\ServiceProvider;
use AvoRed\Framework\Menu\MenuItem;
use AvoRed\Framework\Support\Facades\Menu;

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
        /** @var AvoRed\Framework\Menu\MenuBuilder */
        Menu::make('wechatManage', function (MenuItem $menu) {
            $menu->label('微信管理')
            ->type(MenuItem::ADMIN)
            ->icon('store-front')
            ->route('#');
        });

        /** @var AvoRed\Framework\Menu\MenuItem */
        $wechatManage = Menu::get('wechatManage');
        $wechatManage->subMenu('replay', function (MenuItem $menu) {
            $menu->key('replay')
            ->type(MenuItem::ADMIN)
            ->label('自动回复设置')
            ->route('keyword.index');
        });
        
        $wechatManage->subMenu('material', function (MenuItem $menu) {
            $menu->key('material')
            ->type(MenuItem::ADMIN)
            ->label('素材设置')
            ->route('material.index');
        });
    }
}
