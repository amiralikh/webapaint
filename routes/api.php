<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[\App\Http\Controllers\Api\AuthController::class,'loginUser']);

Route::group(['middleware'=>['auth:sanctum']],function () {
   Route::get('shapes',[\App\Http\Controllers\Api\ShapeController::class,'userShapes'])->name('user.shapes');
   Route::post('shapes',[\App\Http\Controllers\Api\ShapeController::class,'store'])->name('user.shape.store');
   Route::post('shapes/{shape_id}',[\App\Http\Controllers\Api\ShapeController::class,'userShape'])->name('user.shape.show');
   Route::put('shapes/{shape_id}',[\App\Http\Controllers\Api\ShapeController::class,'updateShape'])->name('user.shape.update');
   Route::delete('shapes/{shape_id}',[\App\Http\Controllers\Api\ShapeController::class,'destroy'])->name('user.shape.destroy');
   Route::get('drawings',[\App\Http\Controllers\Api\DrawingController::class,'userDrawings']);
   Route::post('drawings',[\App\Http\Controllers\Api\DrawingController::class,'store']);
   Route::get('drawing/{drawing_id}',[\App\Http\Controllers\Api\DrawingController::class,'userDrawing']);
   Route::put('drawing/{drawing_id}',[\App\Http\Controllers\Api\DrawingController::class,'updateDrawing']);
   Route::delete('drawing/{drawing_id}',[\App\Http\Controllers\Api\DrawingController::class,'destroy']);

});
