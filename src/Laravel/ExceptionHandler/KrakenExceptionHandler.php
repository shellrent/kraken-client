<?php

namespace Shellrent\KrakenClient\Laravel\ExceptionHandler;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;
use Throwable;

class KrakenExceptionHandler extends ExceptionHandler{
	public final function register(): void {

		$this->reportable(function ( Throwable $e) {
            if( !App::isProduction() ) {
                return;
            }
            
			try {
				$builder = config('kraken.exception_report_builder' );
				$report = (new $builder)( $e );

				KrakenClient::sendReport( $report->getData() );

			} catch( Throwable $fatalException ) {
				$fatalErrorHandler = config('kraken.fatal_error_handler' );
				(new $fatalErrorHandler)( $fatalException, $e );
			}
		});
	}
}
