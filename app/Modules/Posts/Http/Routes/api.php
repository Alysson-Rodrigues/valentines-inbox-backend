<?php

use App\Modules\Posts\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

// Group routes in sanctum middleware 
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/posts', [PostsController::class, 'index']);
    Route::post('/posts', [PostsController::class, 'store']);
    Route::post('/posts/{post}', [PostsController::class, 'update']);
    Route::get('/posts/{post}', [PostsController::class, 'show']);
    Route::get('/post/{slug}', [PostsController::class, 'getBySlug']);
});
