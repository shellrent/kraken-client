<?php

namespace Shellrent\KrakenClient\Laravel\Console;

use Illuminate\Console\Command;
use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;

class TestConnection extends Command {
	protected $signature = 'kraken:test';
	
	protected $description = 'Test the connection with the kraken application';
	
	public function handle() {
		$result = json_decode( KrakenClient::testConnection()->getBody() );
		$reportTypes = $result->data->types;
		
		$this->info( $result->data->message );
		
		$exceptionType = config( 'kraken.exception_report_type' );
		if( in_array( $exceptionType, $reportTypes ) ) {
			$this->info( sprintf( 'Exception type "%s" successfully configured', $exceptionType ) );
		} else {
			$this->error( sprintf( 'Exception type "%s" not configured', $exceptionType ) );
		}
		
		$logType = config('kraken.log_report_type' );
		if( in_array( $logType, $reportTypes ) ) {
			$this->info( sprintf( 'Log type "%s" successfully configured', $logType ) );
		} else {
			$this->error( sprintf( 'Log type "%s" not configured', $logType ) );
		}
		
		$this->line( 'Available report types: ' . implode( ' - ', $reportTypes ) );
	}
}