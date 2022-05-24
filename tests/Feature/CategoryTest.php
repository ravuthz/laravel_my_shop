<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_crud_category_api()
    {
        $this->user = Passport::actingAs(
            User::factory()->create()
        );

        $this->assertJsonResult($this->getJson('/api/category'), 200);

        $this->assertJsonResult($this->apiCreate(), 201);

        $this->assertJsonResult($this->apiUpdate(), 200);

        $this->assertJsonResult($this->apiDelete(), 200);

        $this->assertJsonFailed($this->apiCreateFailedValidate(), 422)
            ->assertJsonValidationErrorFor('name');

        $this->assertJsonFailed($this->apiUpdateFailedValidate(), 422)
            ->assertJsonValidationErrorFor('name');
    }

    private function apiCreate()
    {
        return $this->postJson('/api/category', [
            'name' => 'Test Category 1',
            'slug' => 'test-category-1',
            'description' => 'Test Category 1 - create'
        ]);
    }

    private function apiUpdate()
    {
        return $this->patchJson('/api/category/1', [
            'name' => 'Test Category 1',
            'slug' => 'test-category-1',
            'description' => 'Test Category 1 - update'
        ]);
    }

    private function apiDelete()
    {
        return $this->deleteJson('/api/category/1');
    }

    private function apiCreateFailedValidate()
    {
        return $this->postJson('/api/category', [
            'name1' => 'Test Category 2',
            'slug1' => 'test-category-2',
            'description' => 'Test Category 2'
        ]);
    }

    private function apiUpdateFailedValidate()
    {
        return $this->patchJson('/api/category/1', [
            'name1' => 'Test Category 2',
            'slug1' => 'test-category-2',
            'description' => 'Test Category 2'
        ]);
    }

}
