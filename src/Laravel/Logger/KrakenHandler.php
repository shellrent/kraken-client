<?php

namespace Shellrent\KrakenClient\Laravel\Logger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class KrakenHandler extends AbstractProcessingHandler {
	protected function write( LogRecord $record ): void {
		dump($record);exit();
	}
}