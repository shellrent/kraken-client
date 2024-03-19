<?php

namespace Shellrent\KrakenClient\Phalcon\ReportBuilder;

use Shellrent\KrakenClient\ReportBuilder;
use Throwable;

class ExceptionBuilder extends GenericBuilder {
	public function create( Throwable $exception, $type = 'EXCEPTION' ): ReportBuilder {
		$report = ReportBuilder::createFromException( $exception,  $type );
		
		$this->setApplicationData( $report );
		
		return $report;
	}
}