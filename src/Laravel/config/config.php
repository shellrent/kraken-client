<?php

return [
	'endpoint' => env( 'KRAKEN_ENDPOINT', 'localhost' ),
	'auth_token' => env( 'KRAKEN_AUTH_TOKEN', 'token' ),
	'exception_report_type'=> 'EXCEPTION',
	'log_report_type'=> 'LOG',
	'exception_report_builder' => \Shellrent\KrakenClient\Laravel\ExceptionReportBuilder::class,
	'fatal_error_handler'=> \Shellrent\KrakenClient\Laravel\ExceptionHandler\FatalErrorHandler::class,
];
