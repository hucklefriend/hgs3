<?php

namespace Hgs3\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Hgs3\Models\Orm;

class YourSiteMiddleware
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
        if (Auth::check()) {
            $yourSites = Orm\Site::where('user_id', Auth::id())
                ->orderBy('id')
                ->get();
            view()->share('yourSites', $yourSites);
        }

        return $next($request);
    }
}
