<?php

namespace Shellrent\KrakenClient\Laravel\Console;

use Illuminate\Console\Command;
use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;

class TestConnection extends Command {
	protected $signature = 'kraken:test';
	
	protected $description = 'Test the connection with the kraken application';
	
	public function handle() {
		$this->newLine();
		$this->line( 'Connection: ' );
		try {
			$result = json_decode( KrakenClient::testConnection()->getBody() );
			
		} catch( \Throwable $exception ) {
			$this->error( 'Failed to connect' );
			$this->line( $exception->getMessage() );
			return;
		}
		
		$reportTypes = $result->data->types;
		$modules = $result->data->modules;
		
		$exceptionType = config( 'kraken.exception_report_type' );
		$logType = config('kraken.log_report_type' );
		$appModule = config( 'kraken.app_module_code' );
		$cliModule = config('kraken.cli_module_code' );
		$queue = config('kraken.queue_name' );
		
		
		$this->info( $result->data->message );
		$this->newLine();
		
		$this->line( 'Report type: ' );
		if( in_array( $exceptionType, $reportTypes ) ) {
			$this->info( sprintf( 'Exception type "%s" successfully configured', $exceptionType ) );
		} else {
			$this->error( sprintf( 'Exception type "%s" not configured', $exceptionType ) );
		}
		
		if( in_array( $logType, $reportTypes ) ) {
			$this->info( sprintf( 'Log type "%s" successfully configured', $logType ) );
		} else {
			$this->error( sprintf( 'Log type "%s" not configured', $logType ) );
		}
		
		$this->line( 'Available report types: ' . implode( ' - ', $reportTypes ) );
		$this->newLine();
		
		$this->line( 'Module: ' );
		if( in_array( $appModule, $modules ) ) {
			$this->info( sprintf( 'Module app "%s" successfully configured', $appModule ) );
		} else {
			$this->warn( sprintf( 'Module app "%s" not configured', $appModule ) );
		}
		
		if( in_array( $cliModule, $modules ) ) {
			$this->info( sprintf( 'Module cli "%s" successfully configured', $cliModule ) );
		} else {
			$this->warn( sprintf( 'Module cli "%s" not configured', $cliModule ) );
		}
		
		$this->line( 'Available modules: ' . implode( ' - ', $modules ) );
		$this->newLine();
		
		
		
		$this->line( 'Queue configuration: ' );
		
		if( $queue !== null ) {
			$this->info( 'Reports sent asynchronously via the job queue ' . $queue );
		} else {
			$this->warn( 'Report submission queue is disable, they will be sent synchronously' );
		}
		
		$this->newLine();
	}
}