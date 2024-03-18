<?php

namespace Shellrent\KrakenClient\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Shellrent\KrakenClient\KrakenClient;

class SendReport implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable;
	
	public function __construct(
		private array $reportData
	) {}
	
	
	public function handle( KrakenClient $client ) {
		$client->sendReport( $this->reportData );
	}
}