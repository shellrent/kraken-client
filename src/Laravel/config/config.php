<?php

return [
	'endpoint' => env( 'KRAKEN_ENDPOINT', 'localhost' ),
	'auth_token' => env( 'KRAKEN_AUTH_TOKEN', 'token' ),
	
	/**
	 * null|default
	 */
	'queue_name' =>env( 'KRAKEN_QUEUE_NAME', null ),
	'app_module_code' => 'WEB',
	'cli_module_code' => 'CLI',
	'enabled_envs' => ['production'],
	'exception_report_type'=> 'EXCEPTION',
	'log_report_type'=> 'LOG',
	'exception_report_builder' => \Shellrent\KrakenClient\Laravel\ReportBuilder\ExceptionBuilder::class,
	'log_report_builder' => \Shellrent\KrakenClient\Laravel\ReportBuilder\LogBuilder::class,
	'fatal_error_handler'=> \Shellrent\KrakenClient\Laravel\ExceptionHandler\FatalErrorHandler::class,
];
