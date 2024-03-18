<?php

namespace Shellrent\KrakenClient\Laravel\ExceptionHandler;

use Illuminate\Support\Facades\Log;
use Throwable;

class FatalErrorHandler {
	public function __invoke( Throwable $fatalError, Throwable $originalException ): void {
		Log::channel( 'errorlog' )->critical( $fatalError->getMessage() );
	}
}