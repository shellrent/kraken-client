<?php

namespace Shellrent\KrakenClient\Phalcon;

class KrakenExceptionHandler {
	
	private function __construct(  ) {
	
	}
	
	public static function create(  ): self {
		return new self();
	}
	
	public function report( ?\Throwable $throwable ): void {
		try {
			if(!$throwable) {
				//TODO
			}
			
			$logger = new KrakenLogger();
			
			$logger->exception( $throwable );
			
		} catch( \Throwable $fatalEx ) {
			echo $fatalEx->getMessage(); exit();
		}
	}
}