<?php

namespace Shellrent\KrakenClient\Phalcon;

use Phalcon\Di\Di;
use Shellrent\KrakenClient\Phalcon\Config\Config;

class KrakenService {
	public const CONFIG_BIND = 'kraken-config';
	
	public const LOGGER_CLASS_BIND = KrakenLogger::class;
	
	private function __construct(
		private Config $config
	) {	}
	
	public static function config( ?Di $di = null ): Config {
		$di = $di ?? Di::getDefault();
		if( !$di->has( self::CONFIG_BIND ) ) {
			return Config::default();
		}
		
		return $di->get( self::CONFIG_BIND );
	}
	
	public static function logger( ?Config $config = null, ?Di $di = null): KrakenLogger {
		$di = $di ?? Di::getDefault();
		
		$loggerClass = KrakenLogger::class;

		if( $di->has( self::LOGGER_CLASS_BIND ) ) {
			$loggerClass = $di->get( self::LOGGER_CLASS_BIND );
		}
		
		$config = $config ?? static::config();

		return new $loggerClass( $config );
	}
	
	public static function create( ?Config $config = null ): self {
		$config = $config ?? Config::default();
		return new self( $config );
	}
	
	final public function inject( Di $di ): void {
		$service = $this;
		
		$di->setShared( self::CONFIG_BIND, function () use ( $service ) {
			return $service->config;
		} );
		
		$di->setShared( self::LOGGER_CLASS_BIND, function() {
			return KrakenLogger::class;
		});
	}
}