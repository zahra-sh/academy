<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\TechnologyController;


//Route::get('/test', function () {
//    $u = Auth::user();
//    $r = Auth::user()->role;
//    return response()->json(['role' =>$r,'user'=>$u]);
//})->middleware('role:admin');
    //->withoutMiddleware('role');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/upload-image', [UserController::class, 'uploadImage']);
    Route::post('/opinions', [OpinionController::class, 'create']);
    Route::patch('/options/{id}/activate', [OptionController::class, 'updateActiveStatus']);/////

    Route::post('/technologies', [TechnologyController::class, 'create']);
    Route::get('/users', [UserController::class, 'index']);

    Route::prefix('admin')
//        ->middleware(['role:admin'])
        ->group(function () {
        Route::post('/courses', [CourseController::class, 'create']);
    });
});
//  sanctum needed

Route::patch('/options/{id}/update-text', [OptionController::class, 'updateText']); //
Route::post('/options', [OptionController::class, 'create']);
Route::delete('/options/{id}', [OptionController::class, 'destroy']);

//  /sanctum needed



Route::get('/courses', [CourseController::class, 'index']);
Route::get('/attendees', [UserController::class, 'getAttendees']);
Route::get('/opinions', [OpinionController::class, 'index']);
Route::get('/options', [OptionController::class, 'index']);
Route::get('/technologies', [TechnologyController::class, 'index']);


//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

