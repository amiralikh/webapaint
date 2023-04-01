<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drawing\StoreRequest;
use App\Repository\Drawing\DrawRepo;
use Illuminate\Http\Request;

class DrawingController extends Controller
{
    protected $repo;
    public function __construct(DrawRepo $drawRepo)
    {
        $this->repo = $drawRepo;
    }

    public function create(StoreRequest $request)
    {
        $user = $request->user();
        $this->repo->store($user,$request);
        return response()->json(['message' => 'Drawing created successfully']);
    }
}
