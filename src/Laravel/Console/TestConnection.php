<?php

namespace Shellrent\KrakenClient\Laravel\Console;

use Illuminate\Console\Command;
use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;

class TestConnection extends Command {
	protected $signature = 'kraken:test';
	
	protected $description = 'Test the connection with the kraken application';
	
	public function handle() {
		$result = json_decode( KrakenClient::testConnection()->getBody() );
		
		$this->info( $result->data );
	}
}