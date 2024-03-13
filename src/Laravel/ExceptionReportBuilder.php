<?php

namespace Shellrent\KrakenClient\Laravel;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Shellrent\KrakenClient\ReportBuilder;
use Throwable;

class ExceptionReportBuilder {
	protected function buildReport( Throwable $e ): ReportBuilder {
		$report = ReportBuilder::createFromException( $e, config('kraken.exception_report_type') );
		
		$report->addExtraInfo( 'session', Session::all() );
		$report->addExtraInfo( 'cookie', Cookie::get() );
		$report->addExtraInfo( 'server', Request::server());
		
		$report->addExtraInfo( 'requestUri', Request::getRequestUri() );
		
		return $report;
	}
	
	public final function __invoke( Throwable $exception ): ReportBuilder {
		return $this->buildReport( $exception );
	}
}