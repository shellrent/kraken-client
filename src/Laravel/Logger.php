<?php

namespace Shellrent\KrakenClient\Laravel;


use Psr\Log\LogLevel;
use Shellrent\KrakenClient\Laravel\Facades\KrakenClient;

class Logger {
	public static function write( string $message, string $level ): void {
		$builder = config('kraken.log_report_builder' );
		$report = (new $builder)( $message, $level );
		
		KrakenClient::sendReport( $report->getData() );
	}
	
	public static function info( string $message ): void {
		static::write( $message, LogLevel::INFO );
	}
	
	public static function warning( string $message ): void {
		static::write( $message, LogLevel::WARNING);
	}
	
	public static function error( string $message ): void {
		static::write( $message, LogLevel::ERROR );
	}
	
	public static function emergency( string $message ): void {
		static::write( $message, LogLevel::EMERGENCY );
	}
}