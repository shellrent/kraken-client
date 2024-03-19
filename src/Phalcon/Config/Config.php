<?php

namespace Shellrent\KrakenClient\Phalcon\Config;

use Shellrent\KrakenClient\Phalcon\ReportBuilder\ExceptionBuilder;
use Shellrent\KrakenClient\Phalcon\ReportBuilder\FatalErrorBuilder;
use Shellrent\KrakenClient\Phalcon\ReportBuilder\LogBuilder;

class Config {
	public string $apiEndpoint;
	public string $apiToken;
	public ExceptionBuilder $exceptionBuilder;
	public FatalErrorBuilder $fatalErrorBuilder;
	public LogBuilder $logBuilder;
	public string $exceptionReportType;
	public string $logReportType;
	
	public static function default(): self {
		$config = new self();
		
		$config->apiEndpoint = getenv( 'KRAKEN_API_ENDPOINT' ) ?? 'localhost';
		$config->apiToken =  getenv( 'KRAKEN_API_TOKEN' ) ?? 'token';
		$config->exceptionBuilder = new ExceptionBuilder();
		$config->fatalErrorBuilder = new FatalErrorBuilder();
		$config->logBuilder = new LogBuilder();
		$config->exceptionReportType = 'EXCEPTION';
		$config->logReportType = 'LOG';
		
		
		return $config;
	}
}