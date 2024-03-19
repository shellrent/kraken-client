<?php

namespace Shellrent\KrakenClient\Phalcon\ReportBuilder;

use Shellrent\KrakenClient\ReportBuilder;

class FatalErrorBuilder extends GenericBuilder  {
	public function create( $errno, $errstr, $errfile, $errline, $backtrace, $type = 'EXCEPTION' ): ReportBuilder {
		$report = new ReportBuilder( $type, $errstr );
		
		$report->addExtraInfo( 'exception', 'Fatal: error ' . $errno );
		$report->addExtraInfo( 'fileName', $errfile );
		$report->addExtraInfo( 'fileLine', $errline );
		$report->addExtraInfo( 'backtrace', $backtrace );
		
		$this->setApplicationData( $report );
		
		return $report;
	}
}