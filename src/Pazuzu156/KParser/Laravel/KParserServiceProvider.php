<?php

namespace Pazuzu156\KParser\Laravel;

use Illuminate\Support\ServiceProvider;
use Pazuzu156\KParser\KParser;

class KParserServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('kparser', function($app) {
            return new KParser();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['kparser'];
    }
}
