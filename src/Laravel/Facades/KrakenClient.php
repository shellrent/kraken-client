<?php

namespace Shellrent\KrakenClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static sendReport( array $reportInfo )
 */
class KrakenClient extends Facade {
	protected static function getFacadeAccessor(): string {
		return \Shellrent\KrakenClient\KrakenClient::class;
	}
	
}