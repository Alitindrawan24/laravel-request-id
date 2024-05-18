<?php

return [
    /**
     * Boolean value for enable and disable the request ID on logging
     */
    'enabled' => env('REQUEST_ID_ENABLE', true),
    
    /**
     * Key name for logging context
     */
    'key' => env('REQUEST_ID_KEY', "request_id"),
    
    /**
     * Request ID type for logging
     * Possible values:
     * - uuid
     * - uniqid
     * - static
     */
    'type' => env('REQUEST_ID_TYPE', "uuid"),
    
    /**
     * Prefix for Request ID value
     */
    'prefix' => env('REQUEST_ID_PREFIX', ""),

    /**
     * Boolean value for enable and disable the request ID append from header request
     */
    'header_enabled' => env('REQUEST_ID_HEADER_ENABLE', true),
    
    /**
     * Key name of Request ID in request header
     */
    'header_key' => env('REQUEST_ID_HEADER_KEY', "X-REQUEST-ID"),

    /**
     * Boolean value for enable and disable the request ID append to response header
     */
    'response_enabled' => env('REQUEST_ID_RESPONSE_ENABLE', true),
    
    /**
     * Key name of Request ID in response header
     */
    'response_key' => env('REQUEST_ID_RESPONSE_KEY', "X-REQUEST-ID"),

];
