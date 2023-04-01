<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shapes\StoreRequest;
use App\Repository\Shapes\ShapeRepo;
use Illuminate\Http\Request;

class ShapeController extends Controller
{
    protected $repo;

    public function __construct(ShapeRepo $shapeRepo)
    {
        $this->repo = $shapeRepo;
    }

    public function index()
    {

    }

    public function store(StoreRequest $request)
    {
        $user = $request->user();
        $this->repo->store($request,$user);
        return response()->json(['message' => 'shape created successfully']);

    }
}
