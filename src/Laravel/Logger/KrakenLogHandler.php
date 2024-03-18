<?php

namespace Shellrent\KrakenClient\Laravel\Logger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Shellrent\KrakenClient\Laravel\KrakenLogger;
use Throwable;

class KrakenLogHandler extends AbstractProcessingHandler {
	
	private KrakenLogger $logger;

	/**
	 * Indicates if we should report exceptions, if `false` this handler will ignore records with an exception set in the context.
	 *
	 * @var bool
	 */
	private bool $reportExceptions;
	
	/**
	 * Indicates if we should use the formatted message instead of just the message.
	 *
	 * @var bool
	 */
	private bool $useFormattedMessage;
	
	
	public function __construct( KrakenLogger $logger, $level = Level::Debug, bool $bubble = true, bool $reportExceptions = true, bool $useFormattedMessage = false) {
		parent::__construct( $level, $bubble );
		$this->logger = $logger;
		$this->reportExceptions    = $reportExceptions;
		$this->useFormattedMessage = $useFormattedMessage;
	}
	
	protected function write( LogRecord $record ): void {
		$exception = $record['context']['exception'] ?? null;
		$isException = $exception instanceof Throwable;
		unset($record['context']['exception']);
		
		if (!$this->reportExceptions && $isException) {
			return;
		}
		
		$message = $this->useFormattedMessage ? $record->formatted : $record->message;
		
		if( $isException ) {
			$this->logger->exception( $exception );
		} else {
			$this->logger->log( $record->level->toPsrLogLevel(), $message );
		}
	}
}