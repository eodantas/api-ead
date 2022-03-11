<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupport;
use App\Http\Resources\ReplySupportResource;
use App\Repositories\ReplySupportRepository;
use Illuminate\Http\Request;

class ReplySupportController extends Controller
{
    protected $repository;

    public function __construct(ReplySupportRepository $replySupport)
    {
        $this->repository = $replySupport;
    }

    public function createReply(StoreReplySupport $r)
    {
        return new ReplySupportResource(($this->repository->createReply($r->validated())));
    }
}
