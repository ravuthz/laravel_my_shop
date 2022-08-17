<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->user = Passport::actingAs(
            User::factory()->create()
        );
    }

    public function test_list_categories()
    {
        $this->assertJsonResult($this->getJson('/api/category'), 200);
    }

    public function test_can_create_category()
    {
        $this->assertJsonResult(
            $this->postJson('/api/category', [
                'name' => 'Test Category 1',
                'slug' => 'test-category-1',
                'description' => 'Test Category 1 - create'
            ]),
            201
        );
    }

    public function test_can_update_category()
    {
        $this->assertJsonResult(
            $this->patchJson('/api/category/1', [
                'name' => 'Test Category 1',
                'slug' => 'test-category-1',
                'description' => 'Test Category 1 - update'
            ]),
            200
        );
    }

    public function test_can_delete_category()
    {
        $this->assertJsonResult($this->deleteJson('/api/category/1'), 200);
    }

    public function test_create_with_failed_validate()
    {
        $this->assertJsonFailed(
            $this->postJson('/api/category', [
                'name1' => 'Test Category 2',
                'slug1' => 'test-category-2',
                'description' => 'Test Category 2'
            ]),
            422
        )->assertJsonValidationErrorFor('name');
    }

    public function test_update_with_failed_validate()
    {
        $this->assertJsonFailed(
            $this->patchJson('/api/category/1', [
                'name1' => 'Test Category 2',
                'slug1' => 'test-category-2',
                'description' => 'Test Category 2'
            ]),
            422
        )->assertJsonValidationErrorFor('name');
    }

    public function test_delete_with_not_found_category()
    {
        $this->assertJsonFailed($this->deleteJson('/api/category/10000'), 404);
    }

}
