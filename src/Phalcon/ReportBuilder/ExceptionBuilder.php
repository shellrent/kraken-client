<?php

namespace Shellrent\KrakenClient\Phalcon\ReportBuilder;

use Shellrent\KrakenClient\ReportBuilder;

class ExceptionBuilder extends GenericBuilder {
	
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
		$cookies =  [];
		
		foreach ( explode( ';', (string) $this->request->getServer( 'HTTP_COOKIE' ) ) as $cookie ) {
			$cookiePart = explode( '=', trim( (string) $cookie ) );
			
			if ( isset( $cookiePart[1] ) ) {
				$cookies[$cookiePart[0]] = $cookiePart[1];
				
			} else {
				$cookies[] = $cookiePart[0];
			}
		}
		
		return  $cookies;
	}
	
	protected function getSessionData(): array {
		$session = [];
		foreach( $this->sessionKeys as $sessionKey ) {
			$session[$sessionKey] = $this->session->get( $sessionKey );
		}
		
		return $session;
	}
	
	
	public function create( \Throwable $exception, $type = 'EXCEPTION' ): ReportBuilder {
		$report = ReportBuilder::createFromException( $exception,  $type );
		
		$report->setModule( $this->dispatcher->getModuleName() );

		
		$report->addExtraInfo( 'domain', $this->request->getHttpHost() );
		$report->addExtraInfo( 'requestUri', $this->request->getURI() );
		
		$report->addExtraInfo( 'header', $this->sanitize( $this->request->getHeaders() ) );
		
		$query = $this->request->getQuery();
		unset( $query['_url'] );
		$report->addExtraInfo( 'get', $query );
		
		$post = $this->request->getPost();
		$report->addExtraInfo( 'post', $post );

		$report->addExtraInfo( 'session',  $this->sanitize( $this->getSessionData() ) );
		$report->addExtraInfo( 'cookie', $this->sanitize( $this->getCookieData() ) );
		$report->addExtraInfo( 'server', $this->sanitize( $this->getServerData() ) );
		
		return $report;
	}
}