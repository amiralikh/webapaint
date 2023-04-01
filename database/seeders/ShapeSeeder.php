<?php

namespace Database\Seeders;

use App\Models\Shape;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class ShapeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $types = ['circle', 'rectangle'];
        $colors = ['red', 'blue', 'green'];

        for ($i = 0; $i < 50; $i++) {
            $type = $faker->randomElement($types);
            $color = $faker->randomElement($colors);
            $radius = $type == 'circle' ? $faker->numberBetween(10, 100) : null;
            $width = $type == 'rectangle' ? $faker->numberBetween(10, 100) : null;
            $height = $type == 'rectangle' ? $faker->numberBetween(10, 100) : null;
            $user_id = User::query()->inRandomOrder()->first()->id;
            Shape::create([
                'type' => $type,
                'color' => $color,
                'radius' => $radius,
                'width' => $width,
                'height' => $height,
                'user_id' => $user_id,
            ]);
        }
    }
}
