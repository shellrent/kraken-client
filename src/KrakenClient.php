<?php

namespace Shellrent\KrakenClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class KrakenClient {
	private Client $client;
	private string $endpoint;
	private string $authToken;
	
	public function __construct( string $endpoint, string $authToken ) {
		$this->endpoint = $endpoint;
		$this->authToken = $authToken;
		$this->client = new Client([
			'base_uri' => $this->endpoint,
		]);
	}
	
	private function getHeaders(): array {
		return [
			'Content-Type' => 'application/json',
			'Authorization' => 'Bearer '. $this->authToken
		];
	}
	
	public function testConnection(): ResponseInterface {
		$request = new Request(
			'GET',
			'/api/test_connection',
			$this->getHeaders()
		);
		
		return $this->client->send( $request );
	}
	
	public function sendReport( array $reportInfo, bool $async = true ): void {
		$request = new Request(
			'POST',
			'/api/report',
			$this->getHeaders(),
			json_encode( $reportInfo )
		);
		if( $async ) {
			$this->client->sendAsync( $request );
			
		} else {
			$this->client->send( $request );
		}
	}
}