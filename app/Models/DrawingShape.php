<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrawingShape extends Model
{
    use HasFactory;
    protected $table = 'drawing_shapes';

    protected $fillable = ['drawing_id', 'shape_id', 'x', 'y'];

    public function drawing(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Drawing::class);
    }

    public function shape(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Shape::class);
    }

}
