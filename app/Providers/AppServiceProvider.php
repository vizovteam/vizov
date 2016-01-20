<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Torann\GeoIP\GeoIPFacade as GeoIP;
use App\Page;
use App\City;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $pages = Page::all();
        $cities = City::all();

        view()->share('pages', $pages);
        view()->share('cities', $cities);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
