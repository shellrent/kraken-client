<?php

namespace Shellrent\KrakenClient\Phalcon\ReportBuilder;

use Phalcon\Cli\Dispatcher as CliDispatcher;
use Phalcon\Di\Di;
use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Http\RequestInterface;
use Phalcon\Session\ManagerInterface;
use Shellrent\KrakenClient\ReportBuilder;


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
	
	protected function getServerData(): array {
		$serverKeys = [
			'HTTP_REFERER',
			'HTTP_ORIGIN',
			'HTTP_X_REQUESTED_WITH',
			'HTTP_CONTENT_TYPE',
			'HTTP_ACCEPT_ENCODING',
			'HTTP_ACCEPT_LANGUAGE',
			'HTTP_ACCEPT',
			'HTTP_USER_AGENT',
			'HTTP_HOST',
			'REDIRECT_STATUS',
			'SERVER_NAME',
			'SERVER_PORT',
			'SERVER_ADDR',
			'REMOTE_PORT',
			'REMOTE_ADDR',
			'REQUEST_SCHEME',
			'SERVER_PROTOCOL',
			'DOCUMENT_ROOT',
			'DOCUMENT_URI',
			'REQUEST_URI',
			'SCRIPT_NAME',
			'REQUEST_METHOD',
			'QUERY_STRING',
			'SCRIPT_FILENAME',
			'REQUEST_TIME',
			'ENVIRONMENT',
			'argv',
			'argc',
			'_',
			'LOGNAME',
		];
		
		$data = [];
		
		foreach( $serverKeys as $serverKey ) {
			$data[$serverKey] = $this->request->getServer( $serverKey );
		}
		
		return $data;
	}
	
	protected function getCookieData(): array {
		$data =  [];
		$cookieString =  (string) $this->request->getServer( 'HTTP_COOKIE' );
		foreach ( explode( ';', $cookieString) as $cookie ) {
			if( empty( $cookie ) ) {
				break;
			}
			
			$cookiePart = explode( '=', trim( $cookie ) );
			
			if ( isset( $cookiePart[1] ) ) {
				$data[$cookiePart[0]] = $cookiePart[1];
				
			} elseif( isset( $cookiePart[0] ) ) {
				$data[] = $cookiePart[0];
			}
		}
		
		return  $data;
	}
	
	protected function getSessionData(): array {
		$session = [];
		foreach( $this->sessionKeys as $sessionKey ) {
			$session[$sessionKey] = $this->session->get( $sessionKey );
		}
		
		return $session;
	}
	
	protected function sanitize( array $data ): array {
		foreach( $data as $dataKey => $info ) {
			if( empty( $info ) ) {
				unset( $data[$dataKey] );
				continue;
			}
			
			if( !in_array( $dataKey, $this->hideDataKeys ) ) {
				continue;
			}
			
			$data[$dataKey] = '(hidden)';
		}
		
		return $data;
	}
	
	
	protected function setApplicationData( ReportBuilder $report ): void {
		$report->setModule( $this->dispatcher->getModuleName() );
		
		if ( $this->dispatcher instanceof CliDispatcher ) {
			$report->addExtraInfo( 'command', implode( ' ', $this->request->getServer('argv') ) );
			
		} else {
			$report->addExtraInfo( 'domain', $this->request->getHttpHost() );
			$report->addExtraInfo( 'requestUri', $this->request->getURI() );
			$report->addExtraInfo( 'header', $this->sanitize( $this->request->getHeaders() ) );
		}
		
		
		$query = $this->request->getQuery();
		unset( $query['_url'] );
		$report->addExtraInfo( 'get', $query );
		
		$post = $this->request->getPost();
		$report->addExtraInfo( 'post', $post );
		
		$report->addExtraInfo( 'session',  $this->sanitize( $this->getSessionData() ) );
		$report->addExtraInfo( 'cookie', $this->sanitize( $this->getCookieData() ) );
		$report->addExtraInfo( 'server', $this->sanitize( $this->getServerData() ) );
	}
	
	public function setSessionKeys( array $sessionKeys ): GenericBuilder {
		$this->sessionKeys = $sessionKeys;
		return $this;
	}
	
	public function setHideDataKeys( array $hideDataKeys ): GenericBuilder {
		$this->hideDataKeys = $hideDataKeys;
		return $this;
	}
}