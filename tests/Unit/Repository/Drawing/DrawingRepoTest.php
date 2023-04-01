<?php

namespace Tests\Unit\Repository\Drawing;
use Tests\TestCase;
use App\Repository\Drawing\DrawRepo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Drawing;

class DrawRepoTest extends TestCase
{
    use RefreshDatabase;

    private $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = app(DrawRepo::class);
    }

    /**
     * @test
     */
    public function it_can_create_a_drawing_for_a_user()
    {
        $user = User::factory()->create();
        $request = new Request([
            'title' => 'Test Drawing',
            'description' => 'A drawing for testing purposes',
            'image' => 'image.png'
        ]);

        $this->repo->store($request, $user);

        $this->assertDatabaseHas('drawings', [
            'user_id' => $user->id,
            'title' => 'Test Drawing',
            'description' => 'A drawing for testing purposes',
            'image' => 'image.png'
        ]);
    }

    /**
     * @test
     */
    public function it_can_get_all_drawings_associated_with_a_user()
    {
        $user = User::factory()->create();
        Drawing::factory()->count(3)->create(['user_id' => $user->id]);

        $drawings = $this->repo->userDrawings($user);

        $this->assertCount(3, $drawings);
    }

    /**
     * @test
     */
    public function it_can_get_a_single_drawing_associated_with_a_user()
    {
        $user = User::factory()->create();
        $drawing = Drawing::factory()->create(['user_id' => $user->id]);

        $retrievedDrawing = $this->repo->userDrawing($drawing->id, $user);

        $this->assertEquals($drawing->id, $retrievedDrawing->id);
    }

    /**
     * @test
     */
    public function it_can_update_a_drawing()
    {
        $user = User::factory()->create();
        $drawing = Drawing::factory()->create(['user_id' => $user->id]);

        $request = new Request([
            'title' => 'Updated Drawing',
            'description' => 'An updated drawing for testing purposes',
            'image' => 'updated_image.png'
        ]);

        $this->repo->update($drawing, $request);

        $this->assertDatabaseHas('drawings', [
            'id' => $drawing->id,
            'user_id' => $user->id,
            'title' => 'Updated Drawing',
            'description' => 'An updated drawing for testing purposes',
            'image' => 'updated_image.png'
        ]);
    }

    /**
     * @test
     */
    public function it_can_delete_a_drawing()
    {
        $user = User::factory()->create();
        $drawing = Drawing::factory()->create(['user_id' => $user->id]);

        $this->repo->destroy($drawing, $user);

        $this->assertDatabaseMissing('drawings', [
            'id' => $drawing->id,
            'user_id' => $user->id,
        ]);
    }
}
