<?php

use App\Modules\Inboxes\Http\Controllers\InboxesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/inboxes', [InboxesController::class, 'index']);
    Route::post('/inboxes', [InboxesController::class, 'store']);
    Route::post('/inboxes/{inbox}', [InboxesController::class, 'update']);
    Route::get('/inboxes/{inbox}', [InboxesController::class, 'show']);
    Route::get('/inbox/{slug}', [InboxesController::class, 'getBySlug']);
});

Route::post('/inboxes/{magicLink}/message', [InboxesController::class, 'storeMessage']);