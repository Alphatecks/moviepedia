<?php

use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create_user', [UserAuthController::class, 'user_signup']);
Route::post('/verify_otp', [UserAuthController::class, 'user_verification']);
Route::post('/forget_password', [UserAuthController::class, 'user_forget_password']);
Route::post('/reset_password', [UserAuthController::class, 'user_reset_password']);
Route::post('/login', [UserAuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/change_password', [UserAuthController::class, 'user_change_password']);
});

require __DIR__ . '/admin.php';

Route::fallback(function () {
    return response()->json([
        'code' => 404,
        'message' => 'Route Not Found',
    ], 404);
});
