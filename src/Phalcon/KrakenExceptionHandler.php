<?php

namespace Shellrent\KrakenClient\Phalcon;

use Shellrent\KrakenClient\Phalcon\Config\Config;
use Throwable;

class KrakenExceptionHandler {
	private function __construct(
		protected Config $config,
		protected array $hideDataKey = [],
		protected array $sessionKey = [],
	) {}
	
	public static function create( ?Config $config = null ): self {
		$config = $config ?? Config::default();
		return new self( $config );
	}
	
	protected function getLogger(): KrakenLogger {
		$this->config->exceptionBuilder->setHideDataKeys( $this->hideDataKey );
		$this->config->exceptionBuilder->setSessionKeys( $this->sessionKey );
		
		$this->config->fatalErrorBuilder->setHideDataKeys( $this->hideDataKey );
		$this->config->fatalErrorBuilder->setSessionKeys( $this->sessionKey );
		
		return new KrakenLogger( $this->config );
	}
	
	protected function logException( Throwable $throwable ): void {
		$this->getLogger()->exception( $throwable );
	}
	
	protected function logError( $errno, $errstr, $errfile, $errline, $backtrace ): void {
		$this->getLogger()->fatalError( $errno, $errstr, $errfile, $errline, $backtrace );
	}
	
	public function resetHideDataKey(): self {
		$this->hideDataKey = [];
		return $this;
	}
	
	public function addHideDataKey( string $key ): self {
		$this->hideDataKey[$key] = $key;
		return $this;
	}
	
	public function resetSessionKey(): self {
		$this->sessionKey = [];
		return $this;
	}
	
	public function addSessionKey( string $key ): self {
		$this->sessionKey[$key] = $key;
		return $this;
	}
	
	public function report( ?Throwable $throwable, $errno, $errstr, $errfile, $errline, $backtrace ): void {
		try {
			if( $throwable !== null ) {
				$this->logException( $throwable );
				
			} else {
				$this->logError($errno, $errstr, $errfile, $errline, $backtrace);
			}
		} catch( Throwable $fatalEx ) {
			syslog( LOG_CRIT, $fatalEx->getMessage() );
		}
	}
}