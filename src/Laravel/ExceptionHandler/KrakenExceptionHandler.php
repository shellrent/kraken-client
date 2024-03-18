<?php

namespace Shellrent\KrakenClient\Laravel\ExceptionHandler;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Shellrent\KrakenClient\Laravel\Facades\KrakenLogger;
use Throwable;

class KrakenExceptionHandler extends ExceptionHandler{
	public final function register(): void {
		$this->reportable(function ( Throwable $e) {
			try {
				$enabledEnvs = config( 'kraken.enabled_envs' );
				if( $enabledEnvs !== null and !in_array( App::environment(), $enabledEnvs ) ) {
					return;
				}

				KrakenLogger::exception( $e );
				
			} catch( Throwable $fatalException ) {
				$fatalErrorHandler = config('kraken.fatal_error_handler' );
				(new $fatalErrorHandler)( $fatalException, $e );
			}
		});
	}
}
