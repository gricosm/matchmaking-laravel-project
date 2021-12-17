<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/profile', function(Request $request){
        return auth() -> user();
    });
    Route::post('logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});
// Route::middleware('auth:sanctum') -> get('/user', function (Request $request) {
//     return $request->user();
// });
