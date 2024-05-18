<?php

namespace Alitindrawan24\RequestIDMiddleware\Tests;

use Alitindrawan24\RequestIDMiddleware\RequestIDServiceProvider;
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
