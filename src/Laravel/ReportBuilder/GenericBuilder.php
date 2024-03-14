<?php

namespace Shellrent\KrakenClient\Laravel\ReportBuilder;

use Illuminate\Support\Facades\App;

abstract class GenericBuilder {
	protected function getModule(): ?string {
		return App::runningInConsole() ? config('kraken.cli_module_code' ) : config('kraken.app_module_code' );
	}
}