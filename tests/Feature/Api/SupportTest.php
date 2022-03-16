<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\Support;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Api\Traits\UtilsTrait;
use Tests\TestCase;

class SupportTest extends TestCase
{
    use UtilsTrait;

    public function test_get_my_supports_unauthentidated()
    {
        $response = $this->getJson('/my-supports');

        $response->assertStatus(401);
    }

    public function test_get_my_supports()
    {
        $user = $this->createUser();

        Support::factory()->count(50)->create(['user_id' => $user->id]);
        Support::factory()->count(50)->create();

        $response = $this->getJson('/my-supports', ['Authorization' => "Bearer {$user->createToken('teste')->plainTextToken}"]);

        $response->assertStatus(200)->assertJsonCount(50, 'data');
    }

    public function test_get_supports_unauthenticated()
    {
        $response = $this->getJson('/supports');

        $response->assertStatus(401);
    }

    public function test_get_supports()
    {
        Support::factory()->count(50)->create();

        $response = $this->getJson('/supports', $this->defaultHeaders());

        $response->assertStatus(200)->assertJsonCount(50, 'data');
    }

    public function test_get_supports_filter_lesson()
    {
        $lesson = Lesson::factory()->create();
        Support::factory()->count(50)->create();
        Support::factory()->count(10)->create(['lesson_id' => $lesson->id]);

        $response = $this->json('GET', '/supports', ['lesson' => $lesson->id], $this->defaultHeaders());

        $response->assertStatus(200)->assertJsonCount(10, 'data');
    }

    public function test_create_support_unauthenticated()
    {
        $response = $this->postJson('/supports');

        $response->assertStatus(401);
    }

    public function test_create_support_error_validador()
    {
        $response = $this->postJson('/supports', [], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_create_support()
    {
        $lesson = Lesson::factory()->create();

        $response = $this->postJson('/supports', ['lesson' => $lesson->id, 'status' => 'C', 'description' => 'teste'], $this->defaultHeaders());

        $response->assertStatus(201);
    }
}
