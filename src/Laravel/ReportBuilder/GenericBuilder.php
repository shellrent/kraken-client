<?php

namespace Shellrent\KrakenClient\Laravel\ReportBuilder;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Shellrent\KrakenClient\ReportBuilder;

abstract class GenericBuilder {
	protected function addHttpRequestData( ReportBuilder $report ): void {
		$report->addExtraInfo( 'session', Session::all() );
		$report->addExtraInfo( 'cookie', Cookie::get() );
		$report->addExtraInfo( 'server', Request::server());
		$report->addExtraInfo( 'domain', Request::getHttpHost() );
		$report->addExtraInfo( 'requestUri', Request::getRequestUri() );
		
		$report->addExtraInfo( 'header', Request::header() );
		
		$query = Request::query();
		if( !empty( $query ) ) {
			$report->addExtraInfo( 'get', $query );
		}
		
		$post = Request::post();
		if( !empty( $post ) ) {
			$report->addExtraInfo( 'post', $post );
		}
	}
	
	protected function addCliData( ReportBuilder $report ): void {
		$report->addExtraInfo( 'command', implode( ' ', Request::server( 'argv' ) ) );
		
		$report->addExtraInfo( 'server', [
			'REQUEST_TIME' => Request::server( 'REQUEST_TIME' ),
			'SHELL' => Request::server( 'SHELL' ),
			'LANGUAGE' => Request::server( 'LANGUAGE' ),
			'LANG' => Request::server( 'LANG' ),
			'XDG_SESSION_TYPE' => Request::server( 'XDG_SESSION_TYPE' ),
			'XDG_SESSION_CLASS' => Request::server( 'XDG_SESSION_CLASS' ),
			'TERM' => Request::server( 'TERM' ),
			'USER' => Request::server( 'USER' ),
			'XDG_SESSION_ID' => Request::server( 'XDG_SESSION_ID' ),
			'XDG_RUNTIME_DIR' => Request::server( 'XDG_RUNTIME_DIR' ),
			'PS1' => Request::server( 'PS1' ),
			'PATH' => Request::server( 'PATH' ),
			'_' => Request::server( '_' ),
			'PHP_SELF' => Request::server( 'PHP_SELF' ),
			'PATH_TRANSLATED' => Request::server( 'PATH_TRANSLATED' ),
			'argv' => Request::server( 'argv' ),
			'argc' => Request::server( 'argc' ),
		]);
	}
	
	protected function getModule(): ?string {
		return App::runningInConsole() ? config('kraken.cli_module_code' ) : config('kraken.app_module_code' );
	}
}