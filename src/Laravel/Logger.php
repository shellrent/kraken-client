<?php

namespace Shellrent\KrakenClient\Laravel;

use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;
use Shellrent\KrakenClient\ReportBuilder;

class Logger {
	public static function write( $message ): void {
		$report = new ReportBuilder( config('kraken.log_report_type' ), $message );
		KrakenClient::sendReport( $report->getData() );
	}
}