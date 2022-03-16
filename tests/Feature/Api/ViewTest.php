<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Api\Traits\UtilsTrait;
use Tests\TestCase;

class ViewTest extends TestCase
{
    use UtilsTrait;

    public function test_make_viewed_unautheticated()
    {
        $response = $this->postJson('/lessons/viewed');

        $response->assertStatus(401);
    }

    public function test_make_viewed_error_validator()
    {
        $response = $this->postJson('/lessons/viewed', [], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_make_viewed_invalid_lesson()
    {
        $response = $this->postJson('/lessons/viewed', ['lesson' => 'fake_lesson'], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_make_viewed()
    {
        $lesson = Lesson::factory()->create();

        $response = $this->postJson('/lessons/viewed', ['lesson' => $lesson->id], $this->defaultHeaders());

        $response->assertStatus(200);
    }
}
