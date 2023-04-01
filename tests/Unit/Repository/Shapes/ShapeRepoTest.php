<?php

namespace Tests\Unit\Repository\Shapes;

use App\Models\Shape;
use App\Repository\Shapes\ShapeRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShapeRepoTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $shapeRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->shapeRepo = app()->make(ShapeRepo::class);
    }

    public function testGetUserShapes()
    {
        $user_id = 1;
        Shape::factory()->count(3)->create(['user_id' => $user_id]);

        $shapes = $this->shapeRepo->getUserShapes($user_id);

        $this->assertCount(3, $shapes);
    }

    public function testStore()
    {
        $user_id = 1;

        $shapeData = [
            'type' => 'rectangle',
            'width' => $this->faker->numberBetween(10, 50),
            'height' => $this->faker->numberBetween(10, 50),
            'color' => $this->faker->hexColor,
            'radius' => null
        ];

        $this->shapeRepo->store($shapeData, $user_id);

        $this->assertDatabaseHas('shapes', [
            'user_id' => $user_id,
            'type' => $shapeData['type'],
            'width' => $shapeData['width'],
            'height' => $shapeData['height'],
            'color' => $shapeData['color'],
            'radius' => $shapeData['radius']
        ]);
    }

    public function testGetShape()
    {
        $user_id = 1;
        $shape = Shape::factory()->create(['user_id' => $user_id]);

        $foundShape = $this->shapeRepo->getShape($shape->id, $user_id);

        $this->assertEquals($shape->id, $foundShape->id);
    }

    public function testUpdate()
    {
        $user_id = 1;
        $shape = Shape::factory()->create(['user_id' => $user_id]);

        $shapeData = [
            'type' => 'rectangle',
            'width' => $this->faker->numberBetween(10, 50),
            'height' => $this->faker->numberBetween(10, 50),
            'color' => $this->faker->hexColor,
            'radius' => null
        ];

        $this->shapeRepo->update($shape->id, $user_id, $shapeData);

        $this->assertDatabaseHas('shapes', [
            'id' => $shape->id,
            'type' => $shapeData['type'],
            'width' => $shapeData['width'],
            'height' => $shapeData['height'],
            'color' => $shapeData['color'],
            'radius' => $shapeData['radius']
        ]);
    }

    public function testDestroy()
    {
        $user_id = 1;
        $shape = Shape::factory()->create(['user_id' => $user_id]);

        $this->shapeRepo->destroy($shape->id, $user_id);

        $this->assertDeleted($shape);
    }
}
