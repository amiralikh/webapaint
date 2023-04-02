<?php

namespace Database\Factories;

use App\Models\Drawing;
use App\Models\DrawingShape;
use App\Models\Shape;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DrawingShape>
 */
class DrawingShapeFactory extends Factory
{

    protected $model = DrawingShape::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'drawing_id' => Drawing::factory()->create()->id,
            'shape_id' => Shape::factory()->create()->id,
            'x' => $this->faker->numberBetween(0, 100),
            'y' => $this->faker->numberBetween(0, 100),
            'z' => $this->faker->numberBetween(0, 100),
            'width' => $this->faker->numberBetween(10, 100),
            'height' => $this->faker->numberBetween(10, 100),
            'rotation' => $this->faker->numberBetween(0, 360),
            'color' => $this->faker->hexColor(),
        ];
    }
}
