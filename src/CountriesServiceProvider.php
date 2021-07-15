<?php
/**
 * Created by SlickLabs - Wefabric.
 * User: nathanjansen <nathan@wefabric.nl>
 * Date: 26-03-18
 * Time: 11:54
 */

namespace Wefabric\Countries;

use Illuminate\Support\ServiceProvider;

class CountriesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/countries.php' => config_path('countries.php'),
        ], 'config');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'countries');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/countries'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/countries.php', 'countries');

        $this->app->bind(CountryManager::class, function () {
            $countries = config('countries')['countries'];
            return CountryManagerFactory::create($countries);
        });

        $this->app->alias(CountryManager::class, 'country-manager');
    }

}
