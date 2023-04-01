<?php

namespace Database\Seeders;

use App\Models\Drawing;
use App\Models\Shape;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class DrawingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $users = User::all();
        $shapes = Shape::all();

        foreach ($users as $user) {
            $drawingsCount = rand(2, 5);
            for ($i = 0; $i < $drawingsCount; $i++) {
                $drawing = new Drawing();
                $drawing->name = $faker->word();
                $drawing->user_id = $user->id;
                $drawing->save();

                $drawingShapesCount = rand(1, 5);
                for ($j = 0; $j < $drawingShapesCount; $j++) {
                    $shape = $faker->randomElement($shapes);
                    $x = $faker->numberBetween(0, 500);
                    $y = $faker->numberBetween(0, 500);

                    $drawing->shapes()->attach($shape, [
                        'x' => $x,
                        'y' => $y,
                    ]);
                }
            }
        }
    }
}
