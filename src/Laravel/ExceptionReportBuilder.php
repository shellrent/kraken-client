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
		$report->addExtraInfo( 'domain', Request::getHttpHost() );
		$report->addExtraInfo( 'requestUri', Request::getRequestUri() );
		
		$report->addExtraInfo( 'header', Request::header() );
		
		$query = Request::query();
		if( !empty( $query ) ) {
			$report->addExtraInfo( 'get', $query );
		}
		
		$post = Request::post();
		if( !empty( $post ) ) {
			$report->addExtraInfo( 'post', $post );
		}
		
		return $report;
	}
	
	public final function __invoke( Throwable $exception ): ReportBuilder {
		return $this->buildReport( $exception );
	}
}