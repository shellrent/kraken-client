<?php

namespace Shellrent\KrakenClient\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Shellrent\KrakenClient\KrakenClient;
use Throwable;

class SendReport implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable;
	
	public function __construct(
		private array $reportData
	) {}
	
	
	public function handle( KrakenClient $client ) {
		try {
			$client->sendReport( $this->reportData );
			
		} catch( Throwable $exception ) {
			Log::channel( 'syslog' )->critical( $exception->getMessage() );
			Log::channel( 'single' )->critical( $exception->getMessage() );
			$this->fail( $exception );
		}
	}
}