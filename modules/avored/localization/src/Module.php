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
        /*
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path("lang/vendor/avored"),
        ], 'localization');
        */
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'localization');
        //$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');
        Route::prefix('api')
                ->middleware('api')
                ->namespace('Avored\Localization\Http\Controllers')
                ->group(__DIR__ . '/../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'localization');
    }
}
