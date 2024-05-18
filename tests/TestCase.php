<?php

namespace Alitindrawan24\RequestID\Tests;

use Alitindrawan24\RequestID\RequestIDServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function getPackageProviders($app)
    {
        return [
            RequestIDServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->config->set('app.aliases', "test");
    }
}
