<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    public function testGetUserDrawingsRoute()
    {
        $response = $this->get('/api/drawings');

        $response->assertStatus(200);
        $response->assertJsonStructure(['drawings']);
    }

    public function testGetUserDrawingRoute()
    {
        $response = $this->get('/api/drawings/1');

        $response->assertStatus(200);
        $response->assertJsonStructure(['drawing']);
    }

    public function testCreateDrawingRoute()
    {
        $data = [
            'title' => 'Test Drawing',
            'description' => 'This is a test drawing',
            'image' => 'test-image.jpg',
        ];

        $response = $this->postJson('/api/drawings', $data);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Drawing created successfully']);
    }

    public function testUpdateDrawingRoute()
    {
        $data = [
            'title' => 'Updated Drawing Title',
            'description' => 'This is an updated test drawing',
            'image' => 'updated-test-image.jpg',
        ];

        $response = $this->putJson('/api/drawings/1', $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Drawing updated successfully']);
    }

    public function testDeleteDrawingRoute()
    {
        $response = $this->delete('/api/drawings/1');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Drawing deleted successfully']);
    }
}
