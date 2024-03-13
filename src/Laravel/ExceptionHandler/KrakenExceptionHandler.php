<?php

namespace Shellrent\KrakenClient\Laravel\ExceptionHandler;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;
use Throwable;

class KrakenExceptionHandler extends ExceptionHandler{
	public final function register(): void {
		$this->reportable(function ( Throwable $e) {
			try {
				$builder = config('kraken.exception_report_builder' );
				$report = (new $builder)( $e );
				
				KrakenClient::sendReport( $report->getData() );
				
			} catch( Throwable $fatalException ) {
				$fatalErrorHandler = config('kraken.fatal_error_handler' );
				(new $fatalErrorHandler)( $e, $fatalException );
			}
		});
	}
}