<?php

namespace Shellrent\KrakenClient\Laravel\Logger;

use Illuminate\Log\LogManager;
use Monolog\Logger;

class KrakenLogChannel extends LogManager {
	public function __invoke(array $config = []): Logger{
		$handler = new KrakenHandler();
		
		return new Logger(
			$this->parseChannel($config),
			[
				$this->prepareHandler($handler, $config),
			]
		);
	}
}