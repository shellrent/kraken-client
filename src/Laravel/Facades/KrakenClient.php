<?php

namespace Shellrent\KrakenClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Psr\Http\Message\ResponseInterface;

/**
 * @method static ResponseInterface sendReport( array $reportInfo  )
 * @method static ResponseInterface testConnection()
 */
class KrakenClient extends Facade {
	protected static function getFacadeAccessor(): string {
		return \Shellrent\KrakenClient\KrakenClient::class;
	}
}