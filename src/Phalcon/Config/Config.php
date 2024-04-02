<?php

namespace Shellrent\KrakenClient\Phalcon\Config;

use Closure;
use Shellrent\KrakenClient\Phalcon\ReportBuilder\ExceptionBuilder;
use Shellrent\KrakenClient\Phalcon\ReportBuilder\FatalErrorBuilder;
use Shellrent\KrakenClient\Phalcon\ReportBuilder\LogBuilder;

class Config {
	public string $apiEndpoint;
	public string $apiToken;
	public bool $verifySsl;
	public ExceptionBuilder $exceptionBuilder;
	public FatalErrorBuilder $fatalErrorBuilder;
	public LogBuilder $logBuilder;
	public string $exceptionReportType;
	public string $logReportType;
	public ?Closure $userDataGetter = null;
	
	
	public static function default(): self {
		$config = new self();
		$config->apiEndpoint = getenv( 'KRAKEN_API_ENDPOINT' ) ?? 'localhost';
		$config->apiToken =  getenv( 'KRAKEN_API_TOKEN' ) ?? 'token';
		$config->verifySsl = true;
		$config->exceptionBuilder = new ExceptionBuilder();
		$config->fatalErrorBuilder = new FatalErrorBuilder();
		$config->logBuilder = new LogBuilder();
		$config->exceptionReportType = 'EXCEPTION';
		$config->logReportType = 'LOG';
		
		return $config;
	}
	
	public function __clone() {
		$this->exceptionBuilder = clone $this->exceptionBuilder;
		$this->fatalErrorBuilder = clone $this->fatalErrorBuilder;
		$this->logBuilder = clone $this->logBuilder;
	}
}