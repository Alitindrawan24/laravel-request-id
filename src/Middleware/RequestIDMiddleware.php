<?php

namespace Alitindrawan24\RequestIDMiddleware\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RequestIDMiddleware
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
        if($this->_isEnabled()) {
            $key = config("request_id.key");
            $headerKey = config("request_id.header_key");
            $responseKey = config("request_id.response_key");

            $requestID = $this->_generateRequestID();
            if ($this->_isHeaderEnabled() && $request->headers->has($headerKey)) {
                $requestID = $request->header($headerKey);
            }

            Log::withContext([
                $key => $requestID
            ]);

            $response = $next($request);

            if ($this->_isResponseEnabled()) {
                $response->headers->set($responseKey, $requestID);
            }
    
            return $response;
        }

        return $next($request);
    }
    
    /**
     * _isEnabled
     * Function to checking Request ID on log is enabled or not
     *
     * @return bool
     */
    private function _isEnabled(): bool
    {
        return config('request_id.enabled');
    }
        
    /**
     * _isHeaderEnabled
     * Function to checking request header with Request ID is enabled or not
     *
     * @return bool
     */
    private function _isHeaderEnabled(): bool
    {
        return config('request_id.header_enabled');
    }
        
    /**
     * _isResponseEnabled
     * Function to checking response header with Request ID is enabled or not
     *
     * @return bool
     */
    private function _isResponseEnabled(): bool
    {
        return config('request_id.response_enabled');
    }
        
    /**
     * _generateRequestID
     * Function to generate request ID with various type fom config
     *
     * @return string
     */
    private function _generateRequestID(): string
    {
        $type = config('request_id.type');
        $prefix = config('request_id.prefix');
        switch ($type) {
            case 'uuid':
                return $prefix.Str::uuid();
                break;
            case 'uniqueid':
                return Str::uniqid($prefix);
                break;
            default:
                return $prefix."static";
                break;
        }
    }
}
