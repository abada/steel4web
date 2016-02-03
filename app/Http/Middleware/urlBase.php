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
        'urlbase' => env("APP_URL")
    ]);

    }
}
