<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Source;
use App\Models\Author;
use Database\Seeders\AuthorSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\SourceSeeder;
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
        $this->seed(CategorySeeder::class);
        $this->seed(SourceSeeder::class);
        $this->seed(AuthorSeeder::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_stores_preferences_successfully()
    {
        $this->actingAs($this->user);

        // Fetch data from seeded categories, sources, and authors
        $data = [
            'categories' => Category::pluck('id')->take(2)->toArray(),
            'sources' => Source::pluck('id')->take(2)->toArray(),
            'authors' => Author::pluck('id')->take(2)->toArray(),
        ];

        // Use the correct route path for storing preferences
        $response = $this->postJson('/api/save-preferences', $data);

        $response->assertStatus(201)
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

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_validation_errors_for_invalid_preferences()
    {
        $this->actingAs($this->user);

        // Set up invalid test data
        $data = [
            'categories' => ['invalid-data'], // Should be integers
            'sources' => [1, 'string'], // Mixed types
        ];

        // Use the correct route path for storing preferences
        $response = $this->postJson('/api/save-preferences', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['categories.0', 'sources.1']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_retrieves_user_preferences()
    {
        $this->actingAs($this->user);

        // Create a preference for this user
        $this->user->preferences()->create([
            'categories' => [1, 2],
            'sources' => [1, 3],
            'authors' => [2, 4],
        ]);

        // Use the correct route path for retrieving preferences
        $response = $this->getJson('/api/get-preferences');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'categories' => [1, 2],
                     'sources' => [1, 3],
                     'authors' => [2, 4],
                 ]);
    }
}
