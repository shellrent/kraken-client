<?php

namespace Shellrent\KrakenClient\Laravel\ReportBuilder;

use Shellrent\KrakenClient\ReportBuilder;

class LogBuilder extends GenericBuilder {
	protected function buildReport( string $message, string $level ): ReportBuilder {
		$report = new ReportBuilder( config('kraken.log_report_type' ), $message );
		
		$report->setModule( $this->getModule() );
		$report->addExtraInfo( 'level', $level );
		
		$this->addUserInfo( $report );
		
		return $report;
	}
	
	public final function __invoke( string $message, string $level ): ReportBuilder {
		return $this->buildReport( $message, $level );
	}
}