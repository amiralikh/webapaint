<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drawing_shapes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drawing_id');
            $table->foreignId('shape_id');
            $table->decimal('x');
            $table->decimal('y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drawing_shapes');
    }
};
