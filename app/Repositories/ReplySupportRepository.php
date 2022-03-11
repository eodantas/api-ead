<?php

namespace App\Repositories;

use App\Models\ReplySupport;
use App\Repositories\Traits\RepositoryTrait;

class ReplySupportRepository
{
    use RepositoryTrait;

    protected $entity;

    public function __construct(ReplySupport $replySupport)
    {
        $this->entity = $replySupport;
    }

    public function createReply(array $data)
    {
        return $this->entity->create([
            'support_id' => $data['support'],
            'description' => $data['description'],
            'user_id' => $this->getUserAuth()->id
        ]);
    }
}
