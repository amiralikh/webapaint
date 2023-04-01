<?php

namespace App\Repository\Drawing;

class DrawRepo
{
    public function store($user,$request)
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
}
