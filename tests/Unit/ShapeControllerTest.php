<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ShapeControllerTest extends TestCase
{
    public function test_store_method_creates_new_shape_in_database()
    {
        $user = factory(User::class)->create();

        $requestData = [
            'type' => 'square',
            'width' => 10,
            'height' => 10,
            'color' => 'red',
            'radius' => null,
        ];

        $response = $this->actingAs($user)->postJson(route('shapes.store'), $requestData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('shapes', [
            'user_id' => $user->id,
            'type' => 'square',
            'width' => 10,
            'height' => 10,
            'color' => 'red',
            'radius' => null,
        ]);
    }

}
