<?php

return [
	'endpoint' => env( 'KRAKEN_ENDPOINT', 'localhost' ),
	'auth_token' => env( 'KRAKEN_AUTH_TOKEN', 'token' ),
	'exception_report_type'=> 'EXCEPTION',
	'log_report_type'=> 'LOG',
	'cli_module_code' => 'CLI',
	'app_module_code' => 'WEB',
	'enabled_envs' => ['production'],
	'fatal_error_handler'=> \Shellrent\KrakenClient\Laravel\ExceptionHandler\FatalErrorHandler::class,
	'exception_report_builder' => \Shellrent\KrakenClient\Laravel\ReportBuilder\ExceptionBuilder::class,
	'log_report_builder' => \Shellrent\KrakenClient\Laravel\ReportBuilder\LogBuilder::class,
];
