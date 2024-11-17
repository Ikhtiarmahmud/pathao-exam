<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\ApiLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        ApiLogger::startApiLog();

        $response = $next($request);

        $apiLog = ApiLogger::endApiLog($response);

        Log::channel('api-log')->log('info', 'API Request and Response', [
            'context' => $apiLog,
        ]);

        return $response;
    }
}
