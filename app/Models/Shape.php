<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    use HasFactory;

    protected $fillable=['user_id','type','width','color','radius','height'];


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the drawing shapes associated with this shape.
     */
    public function drawingShapes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DrawingShape::class);
    }

    /**
     * Get the drawings associated with this shape through the drawing_shapes table.
     */
    public function drawings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Drawing::class, 'drawing_shapes')
            ->withPivot('x', 'y')
            ->withTimestamps();
    }
}
