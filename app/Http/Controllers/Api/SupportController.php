<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupport;
use App\Http\Resources\SupportResource;
use App\Repositories\SupportRepository;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    protected $repository;

    public function __construct(SupportRepository $support)
    {
        $this->repository = $support;
    }

    public function index(Request $r)
    {
        $supports = $this->repository->getSupports($r->all());

        return SupportResource::collection($supports);
    }

    public function store(StoreSupport $r)
    {
        $support = $this->repository->createNewSupport($r->validated());

        return new SupportResource($support);
    }

    public function mySupports(Request $r)
    {
        $supports = $this->repository->getMySupports($r->all());

        return SupportResource::collection($supports);
    }
}
