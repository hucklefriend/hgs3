<?php

namespace Hgs3\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, \Closure $next)
    {
        // テスト中はCSRF対策を無効化
        if (env('APP_ENV') !== 'testing') {
            return parent::handle($request, $next);
        }

        return $next($request);
    }
}
