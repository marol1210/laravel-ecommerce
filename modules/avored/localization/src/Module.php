<?php
namespace Avored\Localization;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use AvoRed\Framework\Support\Facades\Breadcrumb as BreadcrumbFacade;
use AvoRed\Framework\Breadcrumb\Breadcrumb;

class Module extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResources();
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Registering avored localization Resource
     * e.g. Route, View, Database  & Translation Path
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->publishes(
            [
                __DIR__.'/../resources/vendor/lang' => resource_path("lang/vendor"),  //avored后台多语言配置文件
                __DIR__.'/../resources/vendor/views' => resource_path("views/vendor"),  //avored后台页面重载
                __DIR__.'/../resources/lang' => resource_path("lang")
            ], 
            'localization'
        );
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'localization');
        //$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');
        /*
        Route::prefix('api')
                ->middleware('api')
                ->namespace('Avored\Localization\Http\Controllers')
                ->group(__DIR__ . '/../routes/api.php');
        */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'localization');
    }
}
