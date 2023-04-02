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
   Route::get('shapes',[\App\Http\Controllers\Api\ShapeController::class,'userShapes']);
   Route::post('shapes',[\App\Http\Controllers\Api\ShapeController::class,'store']);
   Route::get('shapes/{shape_id}',[\App\Http\Controllers\Api\ShapeController::class,'userShape']);
   Route::put('shapes/{shape_id}',[\App\Http\Controllers\Api\ShapeController::class,'updateShape']);
   Route::delete('shapes/{shape_id}',[\App\Http\Controllers\Api\ShapeController::class,'destroy']);
   Route::get('drawings',[\App\Http\Controllers\Api\DrawingController::class,'userDrawings']);
   Route::post('drawings',[\App\Http\Controllers\Api\DrawingController::class,'store']);
   Route::get('drawing/{drawing_id}',[\App\Http\Controllers\Api\DrawingController::class,'userDrawing']);
   Route::put('drawing/{drawing_id}',[\App\Http\Controllers\Api\DrawingController::class,'updateDrawing']);
   Route::delete('drawing/{drawing_id}',[\App\Http\Controllers\Api\DrawingController::class,'destroy']);

});
