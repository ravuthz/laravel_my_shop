<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PassportController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [PassportController::class, 'register']);
Route::post('/login', [PassportController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/logout', [PassportController::class, 'logout']);
    Route::get('/user', fn (Request $req) => $req->user());

    Route::apiResource('category', CategoryController::class);
});
