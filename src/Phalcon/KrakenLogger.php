<?php

namespace Shellrent\KrakenClient\Phalcon;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Shellrent\KrakenClient\KrakenClient;
use Shellrent\KrakenClient\Phalcon\Config\Config;
use Shellrent\KrakenClient\ReportBuilder;
use Throwable;

class KrakenLogger implements LoggerInterface {
	private KrakenClient $client;
	private Config $config;
	
	public function __construct( Config $config  ) {
		$this->config = $config;
		$this->client = new KrakenClient( $this->config->apiEndpoint, $this->config->apiToken );
	}
	
	private function dispatch( ReportBuilder $report ): void {
		$this->client->sendReport( $report->getData() );
	}
	
	protected function write( string $message, string $level ): void {
		$report = $this->config->logBuilder->create( $level, $message, $this->config->logReportType );
		
		$this->dispatch( $report );
	}
	
	public function exception( Throwable $exception ): void {
		$report = $this->config->exceptionBuilder->create( $exception, $this->config->exceptionReportType );
		$this->dispatch( $report );
	}
	
	public function fatalError( $errno, $errstr, $errfile, $errline, $backtrace ) {
		$report = $this->config->fatalErrorBuilder->create( $errno, $errstr, $errfile, $errline, $backtrace, $this->config->exceptionReportType );
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