<?php

namespace Shellrent\KrakenClient;

use Throwable;

abstract class GenericKrakenLogger {
	
	abstract public function log( string $level, string $message): void;

	abstract public function exception( Throwable $exception ): void;
	
	public function emergency( string $message ): void {
		$this->log( 'emergency', $message );
	}
	
	public function alert( string $message ): void {
		$this->log( 'alert', $message );
	}
	
	public function critical( string $message ): void {
		$this->log( 'critical', $message );
	}
	
	public function error( string $message ): void {
		$this->log( 'error', $message );
	}
	
	public function warning( string $message ): void {
		$this->log( 'warning', $message );
	}
	
	public function notice( string $message ): void {
		$this->log( 'notice', $message );
	}
	
	public function info( string $message ): void {
		$this->log( 'info', $message );
	}
	
	public function debug( string $message ): void {
		$this->log( 'debug', $message );
	}
}