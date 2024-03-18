<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Kraken api credential
    |--------------------------------------------------------------------------
	|
	| These values represent the endpoint and bearer token for kraken app
	| On the kraken application you just need to configure an environment
	| from the project page, to get the auth token
	|
    */
	
	'endpoint' => env( 'KRAKEN_ENDPOINT', 'localhost' ),
	
	'auth_token' => env( 'KRAKEN_AUTH_TOKEN', 'token' ),
	
	/*
    |--------------------------------------------------------------------------
    | Queue for report job
	|--------------------------------------------------------------------------
	|
	| This value indicates the name of the queue to which jobs will be added
	| If set to null the queue is disabled and reports will be sent immediately
	| By setting "default" jobs will be added to the system's default queue
	|
    */
	
	'queue_name' =>env( 'KRAKEN_QUEUE_NAME', null ),
	
	/*
    |--------------------------------------------------------------------------
    | Application module
	|--------------------------------------------------------------------------
	|
	| By default the Laravel application is divided into two modules
	| The app module represents all http requests
	| The cli module represents executions of cli commands via artisan
	| The values indicate the code corresponding to the configured module
	| in the kraken application
	|
	*/
	'app_module_code' => 'WEB',
	
	'cli_module_code' => 'CLI',
	
	/*
    |--------------------------------------------------------------------------
    | Environments for the exception handler
	|--------------------------------------------------------------------------
	|
	| The collection of values indicates on which environments the kraken
	| exception handler sends the report
	| If set null always send, if the collection is empty it never sends
	|
	*/
	
	'enabled_envs' => ['production'],
	
	/*
    |--------------------------------------------------------------------------
    | Exception report configuration
	|--------------------------------------------------------------------------
	|
	| These values represent the configuration for generating a exception report
	| The type corresponds to the code configured on the kraken application on
	| the project page. Its correct configuration is mandatory
	| The builder is the class that builds the report
	|
	*/
	
	'exception_report_type'=> 'EXCEPTION',
	
	'exception_report_builder' => \Shellrent\KrakenClient\Laravel\ReportBuilder\ExceptionBuilder::class,
	
	/*
    |--------------------------------------------------------------------------
    | Log report configuration
	|--------------------------------------------------------------------------
	|
	| These values represent the configuration for generating a log report
	| The type corresponds to the code configured on the kraken application on
	| the project page. Its correct configuration is mandatory
	| The builder is the class that builds the report
	|
	*/
	
	'log_report_type'=> 'LOG',
	
	'log_report_builder' => \Shellrent\KrakenClient\Laravel\ReportBuilder\LogBuilder::class,
	
];
