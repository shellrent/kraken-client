<?php

namespace Shellrent\KrakenClient\Laravel\Logger;

use Illuminate\Log\LogManager;
use Monolog\Level;
use Monolog\Logger;

class KrakenLogChannel extends LogManager {
	public function __invoke(array $config = []): Logger{
		$handler = new KrakenLogHandler(
			$config['level'] ?? Level::Debug,
			$config['bubble'] ?? true,
			$config['report_exceptions'] ?? false,
			isset($config['formatter']) && $config['formatter'] !== 'default'
		);
		
		return new Logger(
			$this->parseChannel($config),
			[
				$this->prepareHandler($handler, $config),
			]
		);
	}
}