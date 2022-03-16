<?php

namespace Tests\Feature\Api;

use App\Models\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Api\Traits\UtilsTrait;
use Tests\TestCase;

class ReplySupportTest extends TestCase
{
    use UtilsTrait;

    public function test_create_reply_to_support_unauthenticated()
    {
        $response = $this->postJson('/replies');

        $response->assertStatus(401);
    }

    public function test_create_reply_to_support_error_validator()
    {
        $response = $this->postJson('/replies', [], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_create_reply_to_support()
    {
        $support = Support::factory()->create();

        $response = $this->postJson('/replies', ['support' => $support->id, 'description' => 'teste'], $this->defaultHeaders());

        $response->assertStatus(201);
    }
}
