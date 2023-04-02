<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shapes\StoreRequest;
use App\Http\Requests\Shapes\UpdateRequest;
use App\Repository\Shapes\ShapeRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShapeController extends Controller
{
    protected $repo;

    public function __construct(ShapeRepo $shapeRepo)
    {
        $this->repo = $shapeRepo;
    }

    /**
     * Store a newly created shape in storage.
     *
     * @param  \App\Http\Requests\Shapes\StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $user = $request->user();

        // create a new shape with the request data and the authenticated user
        $this->repo->store($request, $user->id);

        return response()->json(['message' => 'Shape created successfully']);
    }

    /**
     * Get all the shapes for a specific user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function userShapes(Request $request): JsonResponse
    {
        $user = $request->user();

        // get all shapes for the authenticated user
        $shapes = $this->repo->getUserShapes($user->id);

        return response()->json(['shapes' => $shapes]);
    }

    /**
     * Get a specific shape for a user.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function userShape($id, Request $request): JsonResponse
    {
        $user = $request->user();

        // get the shape with the given ID and for the authenticated user
        $shape = $this->repo->getShape($id, $user->id);

        return response()->json(['shape' => $shape]);
    }

    /**
     * Update the specified shape in storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function updateShape($id, UpdateRequest $request): JsonResponse
    {
        $user = $request->user();
        // update the shape with the given ID and for the authenticated user
        $this->repo->update($id, $user->id, $request);

        return response()->json(['message' => 'Shape updated successfully']);
    }

    /**
     * Remove the specified shape from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function destroy($id, Request $request): JsonResponse
    {
        $user = $request->user();

        // delete the shape with the given ID and for the authenticated user
        $this->repo->destroy($id, $user->id);

        return response()->json(['message' => 'Shape removed successfully']);
    }
}
