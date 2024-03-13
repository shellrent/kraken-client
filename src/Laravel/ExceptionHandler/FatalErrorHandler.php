<?php

namespace Shellrent\KrakenClient\Laravel\ExceptionHandler;

use Illuminate\Support\Facades\Log;
use Throwable;

class FatalErrorHandler {
	public function __invoke( Throwable $fatalError, Throwable $originalException ): void {
		Log::error( $originalException->getMessage() );
		Log::error( $fatalError->getMessage() );
	}
}