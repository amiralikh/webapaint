<?php

namespace Tests\Unit;

use App\Models\Shape;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShapeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_method_returns_all_shapes_associated_with_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $shapes = Shape::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->get(route('shapes.index'));

        $response->assertOk()
            ->assertJson($shapes->toArray())
            ->assertJsonCount($shapes->count());
    }

    /**
     * @test
     */
    public function store_method_creates_a_new_shape_associated_with_authenticated_user_and_returns_it()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'type' => 'square',
            'width' => 10,
            'height' => 10,
            'color' => '#000000',
            'radius' => null,
        ];

        $response = $this->post(route('shapes.store'), $data);

        $response->assertCreated()
            ->assertJson($data)
            ->assertJsonStructure([
                'id',
                'user_id',
                'type',
                'width',
                'height',
                'color',
                'radius',
                'created_at',
                'updated_at'
            ]);

        $this->assertDatabaseHas('shapes', array_merge($data, ['user_id' => $user->id]));
    }

    /**
     * @test
     */
    public function show_method_returns_single_shape_associated_with_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $shape = Shape::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('shapes.show', ['shape' => $shape->id]));

        $response->assertOk()
            ->assertJson($shape->toArray())
            ->assertJsonStructure([
                'id',
                'user_id',
                'type',
                'width',
                'height',
                'color',
                'radius',
                'created_at',
                'updated_at'
            ]);
    }

    /**
     * @test
     */
    public function update_method_updates_a_single_shape_associated_with_authenticated_user_and_returns_it()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $shape = Shape::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'type' => 'circle',
            'width' => 20,
            'height' => 20,
            'color' => '#ffffff',
            'radius' => 5,
        ];

        $response = $this->patch(route('shapes.update', ['shape' => $shape->id]), $updatedData);

        $response->assertOk()
            ->assertJson($updatedData)
            ->assertJsonStructure([
                'id',
                'user_id',
                'type',
                'width',
                'height',
                'color',
                'radius',
                'created_at',
                'updated_at'
            ]);

        $this->assertDatabaseHas('shapes', array_merge(['id' => $shape->id], $updatedData));
    }

    public function test_destroy_method_deletes_a_single_shape_associated_with_authenticated_user_and_returns_no_content()
    {
        // create a fake user
        $user = User::factory()->create();

        // create a fake shape associated with the fake user
        $shape = Shape::factory()->create([
            'user_id' => $user->id,
        ]);

        // simulate an authenticated user
        $this->actingAs($user);

        // send a DELETE request to the destroy endpoint with the shape ID
        $response = $this->delete(route('shapes.destroy', ['shape' => $shape->id]));

        // assert that the response has status code 204 (no content)
        $response->assertNoContent();

        // assert that the shape no longer exists in the database
        $this->assertDatabaseMissing('shapes', [
            'id' => $shape->id,
        ]);
    }
}
