<?php

namespace Shellrent\KrakenClient;

use Carbon\Carbon;

class ReportBuilder {

	private string $message;
	private string $type;
	private ?string $module = null;
	private Carbon $date;
	private array $extraInfo = [];
	
	public function __construct( string $type, string $message ) {
		$this->message = $message;
		$this->type = $type;
		$this->date = Carbon::now();
	}
	
	/**
	 * @param string $message
	 *
	 * @return ReportBuilder
	 */
	public function setMessage( string $message ): ReportBuilder {
		$this->message = $message;
		return $this;
	}
	
	/**
	 * @param string $type
	 *
	 * @return ReportBuilder
	 */
	public function setType( string $type ): ReportBuilder {
		$this->type = $type;
		return $this;
	}
	
	/**
	 * @param string|null $module
	 *
	 * @return ReportBuilder
	 */
	public function setModule( ?string $module ): ReportBuilder {
		$this->module = $module;
		return $this;
	}
	
	/**
	 * @param Carbon $date
	 *
	 * @return ReportBuilder
	 */
	public function setDate( Carbon $date ): ReportBuilder {
		$this->date = $date;
		return $this;
	}
	
	/**
	 * @param array $extraInfo
	 *
	 * @return ReportBuilder
	 */
	public function addExtraInfo( string $key, $extraInfo ): ReportBuilder {
		$this->extraInfo[$key] = $extraInfo;
		return $this;
	}
	
	public function getData(): array {
		return [
			'message' => $this->message,
			'type' => $this->type,
			'module' => $this->module,
			'acquired_date' => $this->date->format( 'Y-m-d H:i:s' ),
			'data' => $this->extraInfo
		];
	}
	
	public static function createFromException( \Throwable $exception, $type = 'EXCEPTION' ): self {
		$builder = new static( $type, $exception->getMessage() );
		
		$builder->addExtraInfo( 'exception', get_class( $exception ) );
		$builder->addExtraInfo( 'fileLine', $exception->getLine() );
		$builder->addExtraInfo( 'fileName', $exception->getFile() );
		$builder->addExtraInfo( 'backtrace', $exception->getTrace() );
		
		return $builder;
	}
}