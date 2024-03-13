<?php

namespace Shellrent\KrakenClient\Laravel;

use Illuminate\Support\ServiceProvider;
use Shellrent\KrakenClient\KrakenClient;

class KrakenServiceProvider extends ServiceProvider {
	public function register() {
		$this->mergeConfigFrom( __DIR__ . '/config/config.php', 'kraken' );
		
		$this->app->bind(KrakenClient::class, function ($app) {
			return new KrakenClient( config('kraken.endpoint'), config('kraken.auth_token' ) );
		});
	}
	
	public function boot() {
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__.'/config/config.php' => config_path('kraken.php'),
			], 'config');
		}
	}
}