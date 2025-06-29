<?php

namespace App\Providers;

use App\Models\Admin\MenuModel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env(key:'APP_ENV') !== 'local'){
            URL::forceScheme( scheme: 'https' );
        }

        view()->composer('Master.Layouts.sidebar-left', function ($view) {
            $menus = MenuModel::orderBy('menu_sort', 'ASC')->get();
            $view->with('menu', $menus);
        });
    }
}
