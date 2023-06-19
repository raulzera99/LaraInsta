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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::any('/index', [UserRestController::class, 'index']);
    Route::any('/{user}', [UserRestController::class, 'show']);
    Route::post('/store', [UserRestController::class, 'store']);
    Route::put('/{user}', [UserRestController::class, 'update']);
    Route::delete('/{user}', [UserRestController::class, 'destroy']);
});

Route::prefix('posts')->group(function () {
    Route::any('/index', [PostRestController::class, 'index']);
    Route::any('/{post}', [PostRestController::class, 'show']);
    Route::post('/store', [PostRestController::class, 'store']);
    Route::put('/{post}', [PostRestController::class, 'update']);
    Route::delete('/{post}', [PostRestController::class, 'destroy']);
});

Route::prefix('profiles')->group(function () {
    Route::any('/index', [ProfileRestController::class, 'index']);
    Route::any('/{profile}', [ProfileRestController::class, 'show']);
    Route::post('/store', [ProfileRestController::class, 'store']);
    Route::put('/{profile}', [ProfileRestController::class, 'update']);
    Route::delete('/{profile}', [ProfileRestController::class, 'destroy']);
});

Route::prefix('medias')->group(function () {
    Route::any('/index', [MediaRestController::class, 'index']);
    Route::any('/{media}', [MediaRestController::class, 'show']);
    Route::post('/store', [MediaRestController::class, 'store']);
    Route::put('/{media}', [MediaRestController::class, 'update']);
    Route::delete('/{media}', [MediaRestController::class, 'destroy']);
});

Route::prefix('comments')->group(function () {
    Route::any('/index', [CommentRestController::class, 'index']);
    Route::any('/{comment}', [CommentRestController::class, 'show']);
    Route::post('/store', [CommentRestController::class, 'store']);
    Route::put('/{comment}', [CommentRestController::class, 'update']);
    Route::delete('/{comment}', [CommentRestController::class, 'destroy']);
});

Route::prefix('likes')->group(function () {
    Route::any('/index', [LikeRestController::class, 'index']);
    Route::any('/{like}', [LikeRestController::class, 'show']);
    Route::post('/store', [LikeRestController::class, 'store']);
    Route::put('/{like}', [LikeRestController::class, 'update']);
    Route::delete('/{like}', [LikeRestController::class, 'destroy']);
});

Route::prefix('follows')->group(function () {
    Route::any('/index', [FollowRestController::class, 'index']);
    Route::any('/{follow}', [FollowRestController::class, 'show']);
    Route::post('/store', [FollowRestController::class, 'store']);
    Route::put('/{follow}', [FollowRestController::class, 'update']);
    Route::delete('/{follow}', [FollowRestController::class, 'destroy']);
});

