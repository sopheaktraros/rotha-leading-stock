<?php

namespace App\Providers;

use App\Models\Locale;
use App\Models\NewsEvent;
use App\Models\Footer;
use App\Models\Header;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(190);

        \Blade::if('authorize', function ($permission, $type) {
            return (auth()->check() ? hasPermission($permission, $type) : false);
        });
    }
}
