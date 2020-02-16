<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        If (env('APP_ENV') !== 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
        
        Schema::defaultStringLength(191);
//        \URL::forceRootUrl(\Config::get('app.url'));
//        if (str_contains(\Config::get('app.url'), 'https://')) {
//            \URL::forceScheme('https');
//        }
    }
}
