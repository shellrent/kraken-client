<?php

namespace Shellrent\KrakenClient\Phalcon\ReportBuilder;

use Shellrent\KrakenClient\ReportBuilder;

class LogBuilder extends GenericBuilder {
	public function create( string $level, string $message, $type = 'LOG' ): ReportBuilder {
		$report = new ReportBuilder( $type, $message );
		
		$report->setModule( $this->dispatcher->getModuleName() );
		$report->addExtraInfo( 'level', $level );
		
		return $report;
	}
}