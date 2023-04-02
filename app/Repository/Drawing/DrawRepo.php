<?php

namespace App\Repository\Drawing;

use App\Models\Drawing;
use Illuminate\Support\Facades\DB;

class DrawRepo
{
    public function store($request): void
    {
        // Get the authenticated user
        $user = $request->user();
        // Create the new drawing
        $drawing = $user->drawings()->create([
            'name' => $request->input('name'),
        ]);

        // Attach the shapes to the drawing with their position information
        foreach ($request->input('shapes') as $shapeData) {
            $drawing->shapes()->attach($shapeData['id'], [
                'x' => $shapeData['x'],
                'y' => $shapeData['y'],
            ]);
        }
    }

    public function userDrawings($request)
    {
        $user = $request->user();
        return Drawing::with('shapes')->where('user_id',$user->id)->get();
    }

    public function userDrawing($id,$request): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $user = $request->user();
        return Drawing::with('shapes')->where(['user_id'=>$user->id,'id'=>$id])->firstOrFail();
    }

    public function update($id,$request)
    {
        $user = $request->user();
        $drawing = Drawing::findOrFail($id);

        // Check if the authenticated user is the owner of the drawing
        if ($user->id !== $drawing->user_id) {
            $response = response()->json(['message' => 'You are not authorized to update this drawing.'], 403);
        } else {
            // Update the drawing with the new data
            $drawing->name = $request->input('name');
            $drawing->save();

            // Update the shapes associated with the drawing
            $shapes = $request->input('shapes', []);

            // Detach all existing shapes from the drawing
            $drawing->shapes()->detach();

            // Attach the new shapes to the drawing
            foreach ($shapes as $shape) {
                $drawing->shapes()->attach($shape['id'], ['x' => $shape['x'], 'y' => $shape['y']]);
            }

            $response = response()->json($drawing, 200);
        }
        return $response;

    }

    public function destroy($id,$request)
    {
        $user = $request->user();
        $drawing = Drawing::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        DB::beginTransaction();
        try {
            // Delete all associated shapes
            $shapes = $drawing->shapes()->get();
            foreach ($shapes as $shape) {
                $shape->delete();
            }
            // Delete the drawing
            $drawing->delete();
            DB::commit();
            $response =  response()->json(['message' => 'Drawing and associated shapes deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            $response = response()->json(['message' => 'Error deleting drawing and associated shapes', 'error' => $e->getMessage()], 500);
        }
        return $response;
    }
}
