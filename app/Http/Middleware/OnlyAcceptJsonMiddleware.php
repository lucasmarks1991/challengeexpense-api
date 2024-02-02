<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OnlyAcceptJsonMiddleware
{
    /**
     * Only accept JSON
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $header = $request->header('Accept');
        if ($header != 'application/json') {
            return response(['message' => 'Only JSON requests are allowed'], 406);
        }

        if (!$request->isMethod('post')) return $next($request);

        $header = $request->header('Content-Type');
        if (!Str::contains($header, 'application/json')) {
            return response(['message' => 'Only JSON requests are allowed'], 406);
        }

        return $next($request);
    }
}
