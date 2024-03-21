<?php

namespace Shellrent\KrakenClient\Laravel;

use Shellrent\KrakenClient\GenericKrakenLogger;
use Shellrent\KrakenClient\Laravel\Jobs\SendReport;
use Shellrent\KrakenClient\ReportBuilder;
use Throwable;

class KrakenLogger extends GenericKrakenLogger {
	private ?string $queue;
	
	/**
	 * @param string|null $queueName
	 */
	public function __construct() {
		$this->queue = config( 'kraken.queue_name' );
	}
	
	private function dispatch( ReportBuilder $report ): void {
		if( $this->queue === null ) {
			SendReport::dispatchSync( $report->getData() );
			return;
		}
		
		$job = SendReport::dispatch( $report->getData() );
		
		if( $this->queue != 'default' ) {
			$job->onQueue( $this->queue );
		}
	}
	
	public function log( string $level, string $message ): void {
		$builder = config('kraken.log_report_builder' );
		$report = (new $builder)( $message, $level );
		
		$this->dispatch( $report );
	}
	
	public function onQueue( ?string $queue ): self {
		$this->queue = $queue;
		return $this;
	}
	
	public function exception( Throwable $exception ): void {
		$builder = config('kraken.exception_report_builder' );
		$report = (new $builder)( $exception );
		
		$this->dispatch( $report );
	}
}