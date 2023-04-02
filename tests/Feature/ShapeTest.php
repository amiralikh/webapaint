<?php

namespace Tests\Feature;

use App\Models\Shape;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShapeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test the store method of the ShapeController.
     *
     * @return void
     */
    public function testStore(): void
    {
        $data = [
            'type' => 'circle',
            'width' => 0,
            'height' => 0,
            'color' => 'blue',
            'radius' => '10',
        ];
        $response = $this->actingAs($this->user)->postJson('/api/shapes', $data);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Shape created successfully');
    }

    /**
     * Test the userShapes method of the ShapeController.
     *
     * @return void
     */
    public function testUserShapes(): void
    {
        $shape = Shape::factory(10)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->getJson('/api/shapes');
        $response->assertStatus(200);
        $response->assertJsonStructure([
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
                    'updated_at'
                ]
            ]
        ]);
        $this->assertCount(10,$response->json()['shapes']);
    }

    /**
     * Test the userShape method of the ShapeController.
     *
     * @return void
     */
    public function testUserShape(): void
    {
        $shape = Shape::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->postJson('/api/shapes/' . $shape->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'shape' => [
                'id',
                'user_id',
                'type',
                'color',
                'radius',
                'width',
                'height',
                'created_at',
                'updated_at'
            ]
        ]);
        $this->assertEquals($this->user->id ,$shape->user_id);
    }

    public function test_update_user_shape()
    {
        $shape = Shape::factory()->create(['user_id' => $this->user->id]);

        $data = [
            'type' => 'circle',
            'width' => 0,
            'height' => 0,
            'color' => 'blue',
            'radius' => '10',
        ];
        $response = $this->actingAs($this->user)->putJson('/api/shapes/'.$shape->id, $data);
        $response->assertStatus(200)
            ->assertJsonPath('message', 'Shape updated successfully');
        $this->assertDatabaseHas('shapes',$data+['user_id'=>$this->user->id]);
    }

    public function test_destroy_user_shape()
    {
        $shape = Shape::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->deleteJson('/api/shapes/'.$shape->id);
        $response->assertStatus(200)
            ->assertJsonPath('message', 'Shape removed successfully');

    }

    public function test_prevent_destroy_non_owner()
    {
        $new_user = User::factory()->create();
        $shape = Shape::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($new_user)->deleteJson('/api/shapes/'.$shape->id);
        $response->assertStatus(404);
    }

}
