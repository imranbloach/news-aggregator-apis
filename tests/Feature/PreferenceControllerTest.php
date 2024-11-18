<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Source;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PreferenceControllerTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_stores_preferences_successfully()
    {
        // Log in as the test user
        $this->actingAs($this->user);

        // Create related data to pass validation
        $categories = Category::factory()->count(2)->create();
        $sources = Source::factory()->count(2)->create();
        $authors = Author::factory()->count(2)->create();

        // Set up test data with existing IDs
        $data = [
            'categories' => $categories->pluck('id')->toArray(),
            'sources' => $sources->pluck('id')->toArray(),
            'authors' => $authors->pluck('id')->toArray(),
        ];

        $response = $this->postJson('/api/preferences', $data);

        $response->assertStatus(201) // Check if status is 201 Created
                 ->assertJsonFragment([
                     'user_id' => $this->user->id,
                     'categories' => $data['categories'],
                     'sources' => $data['sources'],
                     'authors' => $data['authors'],
                 ]);

        $this->assertDatabaseHas('preferences', [
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function it_returns_validation_errors_for_invalid_preferences()
    {
        $this->actingAs($this->user);

        // Set up invalid test data
        $data = [
            'categories' => ['invalid-data'], // Should be integers
            'sources' => [1, 'string'], // Mixed types
        ];

        $response = $this->postJson('/api/preferences', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['categories.0', 'sources.1']);
    }

    /** @test */
    public function it_retrieves_user_preferences()
    {
        $this->actingAs($this->user);

        // Create a preference for this user
        $this->user->preferences()->create([
            'categories' => [1, 2],
            'sources' => [1, 3],
            'authors' => [2, 4],
        ]);

        $response = $this->getJson('/api/preferences');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'categories' => [1, 2],
                     'sources' => [1, 3],
                     'authors' => [2, 4],
                 ]);
    }
}
