<?php

namespace Tests\Unit;

use App\Models\Shape;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ShapeControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    /** @test */
    public function index_method_returns_all_shapes_associated_with_authenticated_user()
    {
        $shapes = Shape::factory()->count(2)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('user.shapes'));

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        foreach ($shapes as $shape) {
            $response->assertJsonFragment(['id' => $shape->id]);
        }
    }

    /** @test */
    public function store_method_creates_a_single_shape_associated_with_authenticated_user()
    {
        $data = Shape::factory()->make()->toArray();

        $response = $this->post(route('user.shape.store'), $data);

        $response->assertStatus(201);
        $response->assertJsonFragment(['user_id' => $this->user->id] + $data);
        $this->assertDatabaseHas('shapes', ['user_id' => $this->user->id] + $data);
    }

    /** @test */
    public function show_method_returns_single_shape_associated_with_authenticated_user()
    {
        $shape = Shape::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get(route('user.shape.show', $shape->id));

        $response->assertStatus(200);
        $response->assertJson(['data' => $shape->toArray()]);
    }

    /** @test */
    public function update_method_updates_a_single_shape_associated_with_authenticated_user()
    {
        $shape = Shape::factory()->create(['user_id' => $this->user->id]);
        $data = Shape::factory()->make()->toArray();

        $response = $this->put(route('user.shape.update', $shape->id), $data);

        $response->assertStatus(200);
        $response->assertJsonFragment(['user_id' => $this->user->id] + $data);
        $this->assertDatabaseHas('shapes', ['id' => $shape->id] + ['user_id' => $this->user->id] + $data);
    }

    /** @test */
    public function destroy_method_deletes_a_single_shape_associated_with_authenticated_user_and_returns_no_content()
    {
        $shape = Shape::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete(route('user.shape.destroy', $shape->id));

        $response->assertNoContent();
        $this->assertDatabaseMissing('shapes', ['id' => $shape->id]);
    }
}
