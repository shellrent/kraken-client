<?php

namespace Shellrent\KrakenClient\Laravel\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Shellrent\KrakenClient\KrakenClient;
use Stringable;

class KrakenLogger implements LoggerInterface {
	public function __construct(
		private KrakenClient $client
	) {}
	
	private function write( string $message, string $level ): void {
		$builder = config('kraken.log_report_builder' );
		$report = (new $builder)( $message, $level );
		
		$this->client->sendReport( $report->getData() );
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
	
	public function log( $level, Stringable|string $message, array $context = [] ): void {
		$this->write( $message, $level );
	}
}