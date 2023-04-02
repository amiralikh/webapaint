<?php

namespace App\Repository\Shapes;

use App\Models\Shape;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ShapeRepo
{
    /**
     * Get all the shapes associated with the specified user.
     *
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getUserShapes(int $userId): Collection|array
    {
        return Shape::where('user_id', $userId)->get();
    }

    /**
     * Store a newly created shape in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @return void
     */
    public function store($request, int $userId): void
    {
        Shape::create([
            'user_id' => $userId,
            'type' => $request->input('type'),
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'color' => $request->input('color'),
            'radius' => $request->input('radius')
        ]);
    }

    /**
     * Get the specified shape associated with the specified user.
     *
     * @param  int  $id
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
     */
    public function getShape(int $id, int $userId): Model|\Illuminate\Database\Eloquent\Builder
    {
        return Shape::where(['id' => $id, 'user_id' => $userId])->firstOrFail();
    }

    /**
     * Update the specified shape in the database.
     *
     * @param  int  $id
     * @param  int  $userId
     * @return void
     */
    public function update(int $id, int $userId, $request): void
    {
        $this->getShape($id, $userId)->update([
            'type' => $request->input('type'),
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'color' => $request->input('color'),
            'radius' => $request->input('radius')
        ]);
    }

    /**
     * Remove the specified shape from the database.
     *
     * @param  int  $id
     * @param  int  $userId
     * @return void
     */
    public function destroy(int $id, int $userId): void
    {
        $this->getShape($id, $userId)->delete();
    }
}
