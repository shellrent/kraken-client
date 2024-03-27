<?php

namespace Shellrent\KrakenClient\Laravel\ReportBuilder;

use Illuminate\Support\Facades\App;
use Shellrent\KrakenClient\ReportBuilder;
use Throwable;

class ExceptionBuilder extends GenericBuilder {
	protected function buildReport( Throwable $e ): ReportBuilder {
		$report = ReportBuilder::createFromException( $e, config('kraken.exception_report_type') );
		
		if( App::runningInConsole() ) {
			$this->addCliData( $report );
		} else {
			$this->addHttpRequestData( $report );
		}
		
		$report->setModule( $this->getModule() );
		
		$this->addUserInfo( $report );
		
		return $report;
	}
	
	public final function __invoke( Throwable $exception ): ReportBuilder {
		return $this->buildReport( $exception );
	}
}