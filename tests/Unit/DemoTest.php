<?php

namespace Alitindrawan24\RequestIDMiddleware\Tests\Unit;

use function Pest\Laravel\getJson;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Alitindrawan24\RequestIDMiddleware\Middleware\RequestIDMiddleware;
beforeEach(function() {
    // Setup temporary routes for testing middleware
    Route::middleware(RequestIDMiddleware::class)->get('/test-logging', function () {
        Log::info('Testing log context');
        return response()->json(["message" => "OK"]);
    });
    
    // Setup request id type as static for testing
    Config::set("request_id.type", "static");
});

it('can append request ID correctly', function () {
    Log::shouldReceive('withContext')
        ->with(["request_id" => "static"])
        ->once();

    Log::shouldReceive('info')
        ->once()
        ->with('Testing log context');

    $response = getJson('/test-logging');
    expect($response->headers->get("X-REQUEST-ID"))->toBe('static');
});

it('can append request ID correctly with custom key', function () {
    Config::set('request_id.key', "tracing_id");

    Log::shouldReceive('withContext')
        ->with(["tracing_id" => "static"])
        ->once();

    Log::shouldReceive('info')
        ->once()
        ->with('Testing log context');

    $response = getJson('/test-logging');
    expect($response->headers->get("X-REQUEST-ID"))->toBe('static');
});

it('can append request ID correctly with custom response key', function () {
    Config::set('request_id.response_key', "X-TRACING_ID");

    Log::shouldReceive('withContext')
        ->with(["request_id" => "static"])
        ->once();

    Log::shouldReceive('info')
        ->once()
        ->with('Testing log context');

    $response = getJson('/test-logging');
    expect($response->headers->get("X-TRACING-ID"))->toBe('static');
});

it('can append request ID correctly with custom header key', function () {
    // Set config enable to true
    Config::set('request_id.enabled', true);
    Config::set('request_id.header_key', "X-TRACING-ID");

    Log::shouldReceive('withContext')
        ->with(["request_id" => "static-request"])
        ->once();

    Log::shouldReceive('info')
        ->once()
        ->with('Testing log context');

    $response = getJson('/test-logging', [
        "X-TRACING-ID" => "static-request"
    ]);
    expect($response->headers->get("X-REQUEST-ID"))->toBe('static-request');
});

it('can append request ID correctly with custom prefix', function () {
    // Set config enable to true
    Config::set('request_id.enabled', true);
    Config::set('request_id.prefix', "request-");

    Log::shouldReceive('withContext')
        ->with(["request_id" => "request-static"])
        ->once();

    Log::shouldReceive('info')
        ->once()
        ->with('Testing log context');

    $response = getJson('/test-logging');
    expect($response->headers->get("X-REQUEST-ID"))->toBe('request-static');
});

it('cannot append request ID if the config disabled', function () {
    // Set config enable to true
    Config::set('request_id.enabled', false);

    Log::shouldReceive('info')
        ->once()
        ->with('Testing log context');

    $response = getJson('/test-logging');
    expect($response->headers->get("X-REQUEST-ID", null))->toBe(null);
});

it('cannot append request ID by header if the config disabled', function () {
    Config::set('request_id.header_enabled', false);

    Log::shouldReceive('withContext')
        ->with(["request_id" => "static"])
        ->once();

    Log::shouldReceive('info')
        ->once()
        ->with('Testing log context');

        $response = getJson('/test-logging', [
            "X-REQUEST-ID" => "static-request"
        ]);
    expect($response->headers->get("X-REQUEST-ID", null))->toBe("static");
});

it('cannot get response request ID if the config disabled', function () {
    Config::set('request_id.response_enabled', false);

    Log::shouldReceive('withContext')
        ->with(["request_id" => "static"])
        ->once();

    Log::shouldReceive('info')
        ->once()
        ->with('Testing log context');

        $response = getJson('/test-logging');
    expect($response->headers->get("X-REQUEST-ID", null))->toBe(null);
});
