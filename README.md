<p align="center">
    <img src="logo.png" width="200" alt="Kraken Client Logo">
    <p align="center">
        <a href="https://packagist.org/packages/shellrent/kraken-client"><img alt="Download total" src="https://img.shields.io/packagist/dt/shellrent/kraken-client"></a>
        <a href="https://packagist.org/packages/shellrent/kraken-client"><img alt="Last version" src="https://img.shields.io/packagist/v/shellrent/kraken-client"></a>
        <img alt="Php version" src="https://img.shields.io/packagist/dependency-v/shellrent/kraken-client/php">
    </p>
</p>

------
**kRAKEN** is an application for tracking and managing errors issued by external applications

This library provides a `PHP` client API to facilitate calls to **_kRAKEN_** and an integration for the **Laravel** and **Phalcon** frameworks

The integrations add an **ExceptionHandler**, which carries out a complete report of unhandled exceptions and a **Logger**, which allows you to use the **_kRAKEN_** system for receiving and archiving log messages 

## Table of Contents
- [Get Started](#get-started)
- [Laravel Integration](#laravel)
  - [Integration](#integration-laravel)
  - [ExceptionHandler Usage](#exceptionhandler-usage-laravel)
  - [Logger Usage](#logger-usage-laravel)
  - [Customization](#customization-laravel)
- [Phalcon Integration](#phalcon)
  - [Integration](#integration-phalcon)
  - [ExceptionHandler Usage](#exceptionhandler-usage-phalcon)
  - [Logger Usage](#logger-usage-phalcon)
  - [Customization](#customization-phalcon)

## Get Started
> **Requires [PHP 8.1+](https://php.net/releases/)**

First, install OpenAI via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require shellrent/kraken-client
```

Then interact with kRAKEN's API to send a report:

```php
$report = new \Shellrent\KrakenClient\ReportBuilder( 
  'report-type', //Corresponds to the type code configured on the project on kRAKEN app
  'message' //Message to send
);

$client = new \Shellrent\KrakenClient\KrakenClient( 
  'https://kraken-endpoint.com', //kRAKEN endpoint 
  'auth-token' //Create an "environment" on the project page on kRAKEN app
);

$client->sendReport( $report->getData() );
```

To generate a standard report starting from an exception, simply use the specific `ReportBuilder` method:

```php
try {
    /* code that throws an exception */
    
} catch( Exception $exception ) {
    $report = new \Shellrent\KrakenClient\ReportBuilder::createFromException( $exception );
    
    /* send the report */
}
```

## Laravel

> **Requires [Laravel 10.x](https://laravel.com/docs/10.x)**
>
> Previous or later versions have not yet been tested
> 
> use on other versions is possible at your own risk

There is an integration with the Laravel framework

The Laravel package provides an `ExceptionHandler` and registers the `client API` and a psr logger in the service container

### Integration (Laravel)

To make the package work, you need to add the following settings to the `.env` file:

```dotenv
KRAKEN_ENDPOINT="https://kraken-endpoint.com"
KRAKEN_AUTH_TOKEN="auth-token"
```

To be able to send reports via **queue** you must specify the name of the queue to use in the `.env` file, you can use the "default" value to use the standard queue

```dotenv
KRAKEN_QUEUE_NAME="default"
```

It is possible to test the connection to kraken and that the configurations are correct, using the command:

```bash
php artisan kraken:test
```

### ExceptionHandler Usage (Laravel)

To enable exception reporting via the Exception Handler, you need to set the ExceptionHandler in the file `bootrstrap/app.php`, overriding the current configuration:

```php
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    \Shellrent\KrakenClient\Laravel\KrakenExceptionHandler::class
);
```

It is possible to decide on which environments to activate the sending of reports by modifying `enabled_envs` in the config file; by default only the **production** environment is enabled

For more details see [laravel customization](#customization-laravel)

### Logger Usage (Laravel)

It is possible to send single reports and logs via KrakenLogger using its Facade:

```php
use Shellrent\KrakenClient\Laravel\Facades\KrakenLogger;

KrakenLogger::debug( 'message' );
KrakenLogger::info( 'message' );
KrakenLogger::notice( 'message' );
KrakenLogger::warning( 'message' );
KrakenLogger::error( 'message' );
KrakenLogger::critical( 'message' );
KrakenLogger::alert( 'message' );
KrakenLogger::emergency( 'message' );
```

Instead, to use kraken through the Laravel logging system, you can add kraken as a custom channel in the `config/logging.php` configuration file

It can also be added to the stack channel along with other channels

```php 
/******/
'channels' => [
    /*****/
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'kraken'],
            'ignore_exceptions' => false,
        ],
        /*****/
        'kraken' => [
            'driver' => 'kraken',
            'level' => env('LOG_LEVEL', 'debug'),
            'report_exceptions' => false,
        ],
    /*****/
]
```

The kraken log channel can be used as a replacement for the ExceptionHandler, simply set `'report_exceptions' => true` in the configuration

> [!WARNING]
> 
> Use the ExceptionHandler and the log channel with `'report_exceptions' => true` set, duplicates the reports sent in case of an exception 

### Customization (Laravel)

To be able to modify the configuration you must first publish it via the command:

```bash
php artisan vendor:publish --provider="Shellrent\KrakenClient\Laravel\KrakenServiceProvider"
```

From the file created in `config/kraken.php` you can edit:

- The code of the standard modules used by the framework
- The environments that trigger the ExceptionHandler
- The type code and builder class of an exception report
- The type code and builder class of an log report

For more details see [laravel config file](/src/Laravel/config/config.php)

## Phalcon

> **Requires [Phalcon 5.1](https://docs.phalcon.io)**
>
> Previous or later versions have not yet been tested
> 
> use on other versions is possible at your own risk

### Integration (Phalcon)
### ExceptionHandler Usage (Phalcon)
### Logger Usage (Phalcon)
### Customization (Phalcon)
