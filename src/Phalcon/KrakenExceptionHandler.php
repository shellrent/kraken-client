<?php

namespace Shellrent\KrakenClient\Phalcon;

use Throwable;

class KrakenExceptionHandler {
	
	private function __construct(
		private readonly KrakenLogger $logger
	) {}
	
	public static function create(): self {
		$logger = new KrakenLogger();
		return new self( $logger );
	}
	
	protected function exception( Throwable $throwable ): void {
		$this->logger->exception( $throwable );
	}
	
	protected function error( $errno, $errstr, $errfile, $errline, $backtrace ): void {
		$this->logger->fatalError( $errno, $errstr, $errfile, $errline, $backtrace );
	}
	
	public function report( ?Throwable $throwable, $errno, $errstr, $errfile, $errline, $backtrace ): void {
		try {
			if( $throwable !== null ) {
				$this->exception( $throwable );
				
			} else {
				$this->error($errno, $errstr, $errfile, $errline, $backtrace);
			}
			
		} catch( Throwable $fatalEx ) {
			syslog( LOG_CRIT, $fatalEx->getMessage() );
		}
	}
}