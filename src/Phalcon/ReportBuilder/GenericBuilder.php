<?php

namespace Shellrent\KrakenClient\Phalcon\ReportBuilder;

use Phalcon\Di\Di;
use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Http\RequestInterface;
use Phalcon\Session\ManagerInterface;


abstract class GenericBuilder {
	protected Di $di;
	protected RequestInterface $request;
	protected AbstractDispatcher $dispatcher;
	protected ManagerInterface $session;
	
	protected array $sessionKeys = [];
	protected array $hideDataKeys = [];
	
	public function __construct( ?Di $di = null ) {
		$this->di = $di ?? Di::getDefault();
		$this->request = $this->di->get( 'request' );
		$this->dispatcher = $this->di->get( 'dispatcher' );
		$this->session = $this->di->get('session');
	}
	
	/**
	 * @param array $sessionKeys
	 *
	 * @return GenericBuilder
	 */
	public function setSessionKeys( array $sessionKeys ): GenericBuilder {
		$this->sessionKeys = $sessionKeys;
		return $this;
	}
	
	/**
	 * @param array $hideDataKeys
	 *
	 * @return GenericBuilder
	 */
	public function setHideDataKeys( array $hideDataKeys ): GenericBuilder {
		$this->hideDataKeys = $hideDataKeys;
		return $this;
	}
	
	
	
	public function sanitize( array $data ) {
		foreach( $data as $dataKey => $info ) {
			if( !in_array( $dataKey, $this->hideDataKeys ) ) {
				continue;
			}
			
			$data[$dataKey] = '(hidden)';
		}
		
		return $data;
	}
}