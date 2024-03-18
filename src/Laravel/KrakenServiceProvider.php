<?php

namespace Shellrent\KrakenClient\Laravel;

use Illuminate\Support\ServiceProvider;
use Shellrent\KrakenClient\KrakenClient;
use Shellrent\KrakenClient\Laravel\Console\TestConnection;
use Shellrent\KrakenClient\Laravel\Logger\KrakenLogger;

class KrakenServiceProvider extends ServiceProvider {
	public function register() {
		$this->mergeConfigFrom( __DIR__ . '/config/config.php', 'kraken' );
		
		$this->app->singleton(KrakenClient::class, function () {
			return new KrakenClient( config('kraken.endpoint'), config('kraken.auth_token' ) );
		});
		
		$this->app->singleton( KrakenLogger::class, KrakenLogger::class );
	}
	
	public function boot() {
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__.'/config/config.php' => config_path('kraken.php'),
			], 'config');
			
			$this->commands([
				TestConnection::class
			]);
		}
	}
}