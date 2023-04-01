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

    /**
     * Create a new DrawingController instance.
     *
     * @param  \App\Repository\Drawing\DrawRepo  $drawRepo
     * @return void
     */
    public function __construct(DrawRepo $drawRepo)
    {
        $this->repo = $drawRepo;
    }

    /**
     * Store a newly created drawing in the database.
     *
     * @param  \App\Http\Requests\Drawing\StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->repo->store($request);
        return response()->json(['message' => 'Drawing created successfully']);
    }

    /**
     * Get all the drawings associated with the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userDrawings(Request $request): \Illuminate\Http\JsonResponse
    {
        // Get the authenticated user's drawings from the repository
        $drawings = $this->repo->userDrawings($request);

        // Return the drawings as a JSON response
        return response()->json(['drawings' => $drawings]);
    }

    /**
     * Get a single drawing associated with the authenticated user.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userDrawing($id, Request $request): \Illuminate\Http\JsonResponse
    {
        // Get the authenticated user's drawing with the specified ID from the repository
        $drawing = $this->repo->userDrawing($id, $request);

        // Return the drawing as a JSON response
        return response()->json(['drawing' => $drawing]);
    }

    /**
     * Update the specified drawing in the database.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\Drawing\UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDrawing($id, UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        // Update the drawing with the specified ID in the repository
        $this->repo->update($id, $request);

        // Return a success message as a JSON response
        return response()->json(['message' => 'Drawing updated successfully']);
    }

    /**
     * Remove the specified drawing from the database.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request): \Illuminate\Http\JsonResponse
    {
        // Delete the drawing with the specified ID from the repository
        $this->repo->destroy($id, $request);

        // Return a success message as a JSON response
        return response()->json(['message' => 'Drawing removed successfully']);
    }
}
