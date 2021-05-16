<?php
declare(strict_types=1);

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class DumbCorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' => $request->server('HTTP_ORIGIN'),
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}