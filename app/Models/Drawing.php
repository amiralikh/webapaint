<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    use HasFactory;

    protected $fillable = ['drawing_id',
        'shape_id',
        'x',
        'y'];



    /**
     * Get the drawing shapes associated with this drawing.
     */
    public function drawingShapes()
    {
        return $this->hasMany(DrawingShape::class);
    }

    /**
     * Get the shapes associated with this drawing through the drawing_shapes table.
     */
    public function shapes()
    {
        return $this->belongsToMany(Shape::class, 'drawing_shapes')
            ->withPivot('x', 'y')
            ->withTimestamps();
    }

}
