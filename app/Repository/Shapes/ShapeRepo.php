<?php

namespace App\Repository\Shapes;

use App\Models\Shape;

class ShapeRepo
{
    public function getUserShapes($user): \Illuminate\Database\Eloquent\Collection|array
    {
        return Shape::query()->where('user_id',$user)->get();
    }

    public function store($request,$user)
    {
        Shape::created([
            'user_id' => $user
            ,'type' => $request->input('type')
            ,'width' => $request->input('width')
            ,'height' => $request->input('height')
            ,'color' => $request->input('color')
            ,'radius' => $request->input('radius')
        ]);
    }

    public function getShape($id,$user): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return Shape::query()->where(['id'=>$id,'user_id'=>$user])->firstOrFail();
    }

    public function update($id,$user,$request): void
    {
        $this->getShape($id,$user)->update([
            'type' => $request->input('type')
            ,'width' => $request->input('width')
            ,'height' => $request->input('height')
            ,'color' => $request->input('color')
            ,'radius' => $request->input('radius')
        ]);
    }

    public function destroy($id,$user): void
    {
        $this->getShape($id,$user)->delete();
    }
}
