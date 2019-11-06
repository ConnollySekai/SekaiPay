<?php

namespace App\Http\Middleware;

use Closure;

use App\Services\Localization;

class LocalizeByBrowser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Localization::byBrowser();
        
        return $next($request);
    }
}