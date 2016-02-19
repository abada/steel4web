<?php

namespace App\Http\Middleware;
use Closure;
use JavaScript;

/**
 * Class UrlBase
 * @package App\Http\UrlBase
 */
class UrlBase {

	public function handle($request, Closure $next) {
		JavaScript::put([
			'urlbaseGeral' => env("APP_URL"),
		]);
		return $next($request);

	}
}
