<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->name();
        return [
            'parent_id',
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'status' => 'active',
            'meta' => [],
            'no_order' => 0
        ];
    }
}
