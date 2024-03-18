<?php

namespace Shellrent\KrakenClient\Laravel;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Shellrent\KrakenClient\Laravel\Jobs\SendReport;
use Shellrent\KrakenClient\ReportBuilder;
use Stringable;

class KrakenLogger implements LoggerInterface {
	private ?string $queue;
	
	/**
	 * @param string|null $queueName
	 */
	public function __construct() {
		$this->queue = config( 'kraken.queue_name' );
	}
	
	private function dispatch( ReportBuilder $report ) {
		if( $this->queue !== null ) {
			SendReport::dispatch( $report->getData() )
				->onQueue( $this->queue );
			
		} else {
			SendReport::dispatchSync( $report->getData() );
		}
	}
	
	protected function write( string $message, string $level ): void {
		$builder = config('kraken.log_report_builder' );
		$report = (new $builder)( $message, $level );
		
		$this->dispatch( $report );
	}
	
	public function onQueue( ?string $queue ): self {
		$this->queue = $queue;
		return $this;
	}
	
	public function exception( \Throwable $exception ): void {
		$builder = config('kraken.exception_report_builder' );
		$report = (new $builder)( $exception );
		
		$this->dispatch( $report );
	}
	
	public function log( $level, Stringable|string $message, array $context = [] ): void {
		$this->write( $message, $level );
	}
	
	public function emergency( Stringable|string $message, array $context = [] ): void {
		$this->write( $message, LogLevel::EMERGENCY );
	}
	
	public function alert( Stringable|string $message, array $context = [] ): void {
		$this->write( $message, LogLevel::ALERT );
	}
	
	public function critical( Stringable|string $message, array $context = [] ): void {
		$this->write( $message, LogLevel::CRITICAL );
	}
	
	public function error( Stringable|string $message, array $context = [] ): void {
		$this->write( $message, LogLevel::ERROR );
	}
	
	public function warning( Stringable|string $message, array $context = [] ): void {
		$this->write( $message, LogLevel::WARNING );
	}
	
	public function notice( Stringable|string $message, array $context = [] ): void {
		$this->write( $message, LogLevel::NOTICE );
	}
	
	public function info( Stringable|string $message, array $context = [] ): void {
		$this->write( $message, LogLevel::INFO );
	}
	
	public function debug( Stringable|string $message, array $context = [] ): void {
		$this->write( $message, LogLevel::DEBUG );
	}
}