<?php

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\FilmsController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\RegisterController;

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

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'v1'], function () {
    Route::get('me', function (Request $request) {
        return response()->json($request->user());
    });
    Route::post('logout', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([], 200);
    });
    Route::post('comment', [CommentController::class, 'store']);
    Route::post('comment/reply', [CommentController::class, 'commentReply']);
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('films/search/{param?}', [FilmsController::class, 'search']);
    Route::resource('films', FilmsController::class);
});