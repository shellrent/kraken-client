<?php

namespace Shellrent\KrakenClient\Laravel;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Shellrent\KrakenClient\Laravel\Facades\KrakenLogger;
use Throwable;

class KrakenExceptionHandler extends ExceptionHandler{
	public function register(): void {
		$this->reportable(function ( Throwable $e) {
			$enabledEnvs = config( 'kraken.enabled_envs' );
			if( $enabledEnvs !== null and !in_array( App::environment(), $enabledEnvs ) ) {
				return;
			}

			KrakenLogger::exception( $e );
		});
	}
}
