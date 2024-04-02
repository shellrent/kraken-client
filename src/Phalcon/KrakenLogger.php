<?php

namespace Shellrent\KrakenClient\Phalcon;

use Shellrent\KrakenClient\GenericKrakenLogger;
use Shellrent\KrakenClient\KrakenClient;
use Shellrent\KrakenClient\Phalcon\Config\Config;
use Shellrent\KrakenClient\ReportBuilder;
use Throwable;

class KrakenLogger extends GenericKrakenLogger {
	private KrakenClient $client;
	private Config $config;
	
	public function __construct( Config $config  ) {
		$this->config = $config;
		$this->client = new KrakenClient(
			$this->config->apiEndpoint,
			$this->config->apiToken,
			$this->config->verifySsl
		);
	}
	
	protected function dispatch( ReportBuilder $report ): void {
		if( $this->config->userDataGetter ) {
			$userData = call_user_func( $this->config->userDataGetter );
			$report->addExtraInfo( 'user', $userData );
		}
		
		$this->client->sendReport( $report->getData() );
	}
	
	public function log( string $level, string $message ): void {
		$report = $this->config->logBuilder->create( $level, $message, $this->config->logReportType );
		
		$this->dispatch( $report );
	}
	
	public function exception( Throwable $exception ): void {
		$report = $this->config->exceptionBuilder->create( $exception, $this->config->exceptionReportType );
		$this->dispatch( $report );
	}
	
	public function fatalError( $errno, $errstr, $errfile, $errline, $backtrace ): void {
		$report = $this->config->fatalErrorBuilder->create( $errno, $errstr, $errfile, $errline, $backtrace, $this->config->exceptionReportType );
		$this->dispatch( $report );
	}
}