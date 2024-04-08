<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $origin = $request->header('Origin');
        $response->header('Access-Control-Allow-Origin', $origin ?: '*');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Authorization, X-Requested-With');
        $response->header('Access-Control-Allow-Credentials', 'true');

        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200);
        }

        return $response;
    }
}
