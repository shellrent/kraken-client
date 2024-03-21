<?php

namespace Shellrent\KrakenClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Throwable;

/**
 * @method static self onQueue( ?string $queue )
 * @method static void exception( Throwable $exception )
 * @method static void log( string $level, string $message )
 * @method static void emergency( string $message )
 * @method static void alert( string $message )
 * @method static void critical( string $message )
 * @method static void error( string $message )
 * @method static void warning( string $message )
 * @method static void notice( string $message )
 * @method static void info( string $message )
 * @method static void debug( string $message )
 */
class KrakenLogger extends Facade {
	protected static function getFacadeAccessor(): string {
		return \Shellrent\KrakenClient\Laravel\KrakenLogger::class;
	}
}