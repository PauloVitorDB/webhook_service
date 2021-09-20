<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $service
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $service)
    {
        $response = $next($request);

        $client = $response->headers->get('X-Client-Name');
        
        if($client) {
            
            $req_response = $response->getContent();

            $log = [
                'URI' => $request->getUri(),
                'METHOD' => $request->getMethod(),
                'REQUEST_BODY' => $request->all(),
                'RESPONSE' => $req_response
            ];
    
            $filename = "{$client}_{$service}";
            $file_path = storage_path('logs/' . $filename . '.log');

            $LOG_MAX_DAYS = env('LOG_MAX_DAYS') ? env('LOG_MAX_DAYS') : 1;
            if(file_exists($file_path) && filectime($file_path) < strtotime("-$LOG_MAX_DAYS day")) {
                file_put_contents(($file_path), '');
            }

            $orderLog = new Logger('order');
            $orderLog->pushHandler(new StreamHandler($file_path), Logger::INFO);
            $orderLog->info('ServiceRequestLog', $log);
        
        }
       
        return $response;

    }
}
