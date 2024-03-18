<?php

namespace Shellrent\KrakenClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Stringable;

/**
 * @method static void emergency(string|Stringable $message, array $context = [])
 * @method static void alert(string|Stringable $message, array $context = [])
 * @method static void critical(string|Stringable $message, array $context = [])
 * @method static void error(string|Stringable $message, array $context = [])
 * @method static void warning(string|Stringable $message, array $context = [])
 * @method static void notice(string|Stringable $message, array $context = [])
 * @method static void info(string|Stringable $message, array $context = [])
 * @method static void debug(string|Stringable $message, array $context = [])
 * @method static void log(mixed $level, string|Stringable $message, array $context = [])
 */
class KrakenLogger extends Facade {
	protected static function getFacadeAccessor(): string {
		return \Shellrent\KrakenClient\Laravel\Logger\KrakenLogger::class;
	}
}