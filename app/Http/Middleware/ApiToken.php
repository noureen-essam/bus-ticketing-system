<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $api_env =Config('app.key');
        if ($request->api_token != $api_env) {
            return response()->json('Unauthorized', 401);
        }
        return $next($request);
    }
}
