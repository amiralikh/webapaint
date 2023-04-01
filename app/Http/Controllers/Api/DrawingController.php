<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drawing\StoreRequest;
use App\Http\Requests\Drawing\UpdateRequest;
use App\Repository\Drawing\DrawRepo;
use Illuminate\Http\Request;

class DrawingController extends Controller
{
    protected $repo;
    public function __construct(DrawRepo $drawRepo)
    {
        $this->repo = $drawRepo;
    }

    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->repo->store($request);
        return response()->json(['message' => 'Drawing created successfully']);
    }

    public function userDrawings(Request $request): \Illuminate\Http\JsonResponse
    {
        $drawings = $this->repo->userDrawings($request);
        return response()->json(['drawings' => $drawings]);
    }

    public function userDrawing($id,Request $request): \Illuminate\Http\JsonResponse
    {
        $drawing = $this->repo->userDrawing($id,$request);
        return response()->json(['drawing' => $drawing]);
    }

    public function updateDrawing($id,UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->repo->update($id,$request);
    }

    public function destroy($id,Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->repo->destroy($id,$request);
    }
}
