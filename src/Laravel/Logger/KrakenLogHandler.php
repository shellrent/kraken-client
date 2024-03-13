<?php

namespace Shellrent\KrakenClient\Laravel\Logger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;
use Shellrent\KrakenClient\Laravel\Logger;
use Shellrent\KrakenClient\ReportBuilder;

class KrakenLogHandler extends AbstractProcessingHandler {
	/**
	 * Indicates if we should report exceptions, if `false` this handler will ignore records with an exception set in the context.
	 *
	 * @var bool
	 */
	private $reportExceptions;
	
	/**
	 * Indicates if we should use the formatted message instead of just the message.
	 *
	 * @var bool
	 */
	private $useFormattedMessage;
	
	
	public function __construct($level = Level::Debug, bool $bubble = true, bool $reportExceptions = true, bool $useFormattedMessage = false) {
		parent::__construct( $level, $bubble );
		$this->reportExceptions    = $reportExceptions;
		$this->useFormattedMessage = $useFormattedMessage;
	}
	
	protected function write( LogRecord $record ): void {
		try {
			Logger::write( $record->message );
		} catch( \Throwable  $e ){}
	}
}