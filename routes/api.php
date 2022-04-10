<?php

use App\Http\Controllers\{AuthController, PostController, TestController, UserController};
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

//登录
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['checkPermission'])->group(function () {
    //帖子
    Route::get('post', [PostController::class, 'index'])->name('post.index');
    Route::post('post', [PostController::class, 'store'])->name('post.store');
    Route::get('post/{post}', [PostController::class, 'show'])->name('post.show');
    Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    //用户
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::post('user', [UserController::class, 'index'])->name('user.store');
    Route::get('user/{user}', [UserController::class, 'index'])->name('user.show');
    Route::put('user/{user}', [UserController::class, 'index'])->name('user.update');
    Route::delete('user/{user}', [UserController::class, 'index'])->name('user.destroy');
});

