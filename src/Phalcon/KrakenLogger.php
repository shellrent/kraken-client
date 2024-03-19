<?php

namespace Shellrent\KrakenClient\Phalcon;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Shellrent\KrakenClient\KrakenClient;
use Shellrent\KrakenClient\Phalcon\ReportBuilder\ExceptionBuilder;
use Shellrent\KrakenClient\Phalcon\ReportBuilder\FatalErrorBuilder;
use Shellrent\KrakenClient\Phalcon\ReportBuilder\LogBuilder;
use Shellrent\KrakenClient\ReportBuilder;

class KrakenLogger implements LoggerInterface {
	private KrakenClient $client;
	private ExceptionBuilder $exceptionBuilder;
	private FatalErrorBuilder $fatalErrorBuilder;
	private LogBuilder $logBuilder;
	
	public function __construct( ?KrakenClient $client = null, ?ExceptionBuilder $exceptionBuilder = null, ?FatalErrorBuilder $fatalErrorBuilder = null, ?LogBuilder $logBuilder = null  ) {
		if( !$client ) {
			$client = new KrakenClient(
				env( 'KRAKEN_API_ENDPOINT', 'localhost' ),
				env( 'KRAKEN_API_TOKEN', 'token' )
			);
		}

		$this->client = $client;
		$this->exceptionBuilder = $exceptionBuilder ?? new ExceptionBuilder();
		$this->fatalErrorBuilder = $fatalErrorBuilder ?? new FatalErrorBuilder();
		$this->logBuilder = $logBuilder ?? new LogBuilder();
	}
	
	
	private function dispatch( ReportBuilder $report ): void {
		$this->client->sendReport( $report->getData() );
	}
	
	protected function write( string $message, string $level ): void {
		$report = $this->logBuilder->create( $level, $message );
		
		$this->dispatch( $report );
	}
	
	public function exception( \Throwable $exception ): void {
		$report = $this->exceptionBuilder->create( $exception );
		$this->dispatch( $report );
	}
	
	public function fatalError( $errno, $errstr, $errfile, $errline, $backtrace ) {
		$report = $this->fatalErrorBuilder->create( $errno, $errstr, $errfile, $errline, $backtrace );
		$this->dispatch( $report );
	}
	
	public function log( $level, $message, array $context = [] ): void {
		$this->write( $message, $level );
	}
	
	public function emergency( $message, array $context = [] ): void {
		$this->write( $message, LogLevel::EMERGENCY );
	}
	
	public function alert( $message, array $context = [] ): void {
		$this->write( $message, LogLevel::ALERT );
	}
	
	public function critical( $message, array $context = [] ): void {
		$this->write( $message, LogLevel::CRITICAL );
	}
	
	public function error( $message, array $context = [] ): void {
		$this->write( $message, LogLevel::ERROR );
	}
	
	public function warning( $message, array $context = [] ): void {
		$this->write( $message, LogLevel::WARNING );
	}
	
	public function notice( $message, array $context = [] ): void {
		$this->write( $message, LogLevel::NOTICE );
	}
	
	public function info( $message, array $context = [] ): void {
		$this->write( $message, LogLevel::INFO );
	}
	
	public function debug( $message, array $context = [] ): void {
		$this->write( $message, LogLevel::DEBUG );
	}
}