<?php

namespace Shellrent\KrakenClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class KrakenClient {
	private Client $client;
	private string $endpoint;
	private string $authToken;
	
	public function __construct( string $endpoint, string $authToken, bool $verify = true ) {
		$this->endpoint = $endpoint;
		$this->authToken = $authToken;
		$this->client = new Client([
			'base_uri' => $this->endpoint,
			'verify' => $verify,
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
	
	public function sendReport( array $reportInfo ): ResponseInterface {
		$request = new Request(
			'POST',
			'/api/report',
			$this->getHeaders(),
			json_encode( $reportInfo )
		);
		
		return $this->client->send( $request, [
			RequestOptions::CONNECT_TIMEOUT => 100,
			RequestOptions::TIMEOUT => 10
		] );
	}
}