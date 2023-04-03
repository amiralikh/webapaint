<?php

namespace Tests\Feature;

use App\Models\Drawing;
use App\Models\DrawingShape;
use App\Models\Shape;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DrawingTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }


    public function testUserDrawings()
    {
        $shape = DrawingShape::factory(10)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->getJson('/api/drawings');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'drawings' => [
                '*' => [
                    'id',
                    'user_id',
                    'name',
                    'created_at',
                    'updated_at',
                    'shapes' => [
                        '*' => [
                            'id',
                            'user_id',
                            'type',
                            'color',
                            'radius',
                            'width',
                            'height',
                            'created_at',
                            'updated_at',
                            'pivot' => [
                                '*' => [
                                    'drawing_id',
                                    'shape_id',
                                    'x',
                                    'y',
                                    'created_at',
                                    'updated_at'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
        $this->assertCount(10,$response->json()['drawings']);
    }
}
