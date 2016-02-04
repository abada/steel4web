<?php

namespace App\Http\Middleware;
use JavaScript;
use Closure;


/**
 * Class UrlBase
 * @package App\Http\UrlBase
 */
class UrlBase
{

  public function handle($request, Closure $next)
    {
        JavaScript::put([
        'urlbaseGeral' => env("APP_URL")
   		 ]);
        return $next($request);

    }
}
