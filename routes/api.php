<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\olist\OlistController;

Route::group(['middleware' => ['LogRequest:olist']], function($id) {
    Route::post('/olist/notification', [OlistController::class, 'notification']);
    Route::get('/olist/authentication', [OlistController::class, 'authentication']);
});