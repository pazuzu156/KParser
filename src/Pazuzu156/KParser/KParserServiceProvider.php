<?php namespace Pazuzu156\KParser;

use Illuminate\Support\ServiceProvider;

class KParserServiceProvider extends ServiceProvider
{
	/**
	* Register the service provider.
	*
	* @return void
	*/
	public function register()
	{
		$this->app['kparser'] = $this->app->share(
			function ($app) {
				return new KParser;
			}
		);
	}

	/**
	* Get the services provided by the provider.
	*
	* @return array
	*/
	public function provides()
	{
		return array('kparser');
	}
}
