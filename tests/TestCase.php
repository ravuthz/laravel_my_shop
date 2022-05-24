<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function assertJsonResult(TestResponse $response, $statusCode = 200): TestResponse
    {
        $this->assertIsNotArray($response['errors']);
        return $response
            ->assertStatus($statusCode)
            ->assertJsonStructure([
                "data",
                "errors",
                "message"
            ]);
    }

    public function assertJsonFailed(TestResponse $response, $statusCode = 500): TestResponse
    {
        $this->assertIsArray($response['errors']);
        return $response
            ->assertStatus($statusCode)
            ->assertJsonStructure([
                "errors",
                "message"
            ]);
    }
}
