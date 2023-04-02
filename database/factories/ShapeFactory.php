<?php

namespace Database\Factories;

use App\Models\Shape;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shape>
 */
class ShapeFactory extends Factory
{

    protected $model = Shape::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['square', 'circle', 'rectangle']),
            'width' => $this->faker->randomFloat(2, 0, 100),
            'height' => $this->faker->randomFloat(2, 0, 100),
            'color' => $this->faker->hexColor(),
            'radius' => $this->faker->numberBetween(1, 50),
        ];
    }
}
