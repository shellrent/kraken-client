<?php

namespace Shellrent\KrakenClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class ApiClient {
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
	
	public function sendReport( array $reportInfo ): ResponseInterface {
		$request = new Request(
			'POST',
			'/api/report',
			$this->getHeaders(),
			json_encode( $reportInfo )
		);
		
		return $this->client->send( $request );
	}
}