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


    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $this->repo->store($request,$user);
        return response()->json(['message' => 'shape created successfully']);

    }

    public function userShapes(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $shapes = $this->repo->getUserShapes($user->id);
        return response()->json(['shapes' => $shapes]);

    }

    public function userShape($id,Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $shape = $this->repo->getShape($id,$user->id);
        return response()->json(['shape' => $shape]);

    }

    public function updateShape($id,Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $this->repo->update($id,$user->id,$request);
        return response()->json(['message' => 'shape updated successfully']);

    }

    public function destroy($id,Request $request)
    {
        $user = $request->user();
        $this->repo->destroy($id,$user->id);
        return response()->json(['message' => 'shape removed successfully']);
    }
}
