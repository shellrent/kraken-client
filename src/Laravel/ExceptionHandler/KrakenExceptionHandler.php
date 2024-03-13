<?php

namespace Shellrent\KrakenClient\Laravel\ExceptionHandler;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;
use Shellrent\KrakenClient\ReportBuilder;
use Throwable;

class KrakenExceptionHandler extends ExceptionHandler{
	protected function buildReport( Throwable $e ): ReportBuilder {
		$report = ReportBuilder::createFromException( $e, config('kraken.exception_report_type') );
		
		$report->addExtraInfo( 'session', Session::all() );
		$report->addExtraInfo( 'cookie', Cookie::get() );
		$report->addExtraInfo( 'server', Request::server());
		
		$report->addExtraInfo( 'requestUri', Request::getRequestUri() );
		
		return $report;
	}
	
	public final function register(): void {
		$this->reportable(function ( Throwable $e) {
			try {
				$report = $this->buildReport( $e );
				
				KrakenClient::sendReport( $report->getData() );
				
			} catch( Throwable $fatalException ) {
				$fatalErrorHandler = config('kraken.fatal_error_handler' );
				(new $fatalErrorHandler)( $e, $fatalException );
			}
		});
	}
}