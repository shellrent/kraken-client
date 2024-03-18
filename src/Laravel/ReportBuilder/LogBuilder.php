<?php

namespace Shellrent\KrakenClient\Laravel\ReportBuilder;

use Shellrent\KrakenClient\ReportBuilder;

class LogBuilder extends GenericBuilder {
	protected function buildReport( string $message, string $level ): ReportBuilder {
		$report = new ReportBuilder( config('kraken.log_report_type' ), $message );
		
		$module = $this->getModule();
		if( $module ) {
			$report->setModule( $module );
		}
		
		$report->addExtraInfo( 'level', $level );
		
		return $report;
	}
	
	public final function __invoke( string $message, string $level ): ReportBuilder {
		return $this->buildReport( $message, $level );
	}
}