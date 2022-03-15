<?php

namespace Tests\Feature\Api\Traits;

use App\Models\User;

trait UtilsTrait
{
    public function createTokenUser()
    {
        $user = User::factory()->create();
        $token = $user->createToken('teste')->plainTextToken;

        return $token;
    }
}
