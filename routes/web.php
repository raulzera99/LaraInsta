<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Common Resource Routes:
// index - Show all 
// show - Show single 
// create - Show form to create new 
// store - Store new 
// edit - Show form to edit 
// update - Update 
// delete - Show delete confirmation
// destroy - Delete  


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Auth::routes();
// Auth::routes();
// Create new user form
// Route::get('/register', [Auth\RegisterController::class, 'index'])->name('register');
// // Store a new user
// Route::post('/register', [Auth\RegisterController::class, 'store']);
// // Login form
// Route::get('/login', [Auth\LoginController::class, 'index'])->name('login')->middleware('guest');
// // Login user
// Route::post('/login', [Auth\LoginController::class, 'authenticate']);
// // Logout user
// Route::post('/logout', [Auth\LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Middleware Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);

    Route::resource('posts', PostController::class);

    Route::resource('profiles', ProfileController::class);

});

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/

Route::prefix('users')->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('users.index');

    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');

    Route::get('/create', [UserController::class, 'create'])->name('users.create');

    Route::post('/', [UserController::class, 'store'])->name('users.store');

    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::patch('/{user}', [UserController::class, 'update'])->name('users.update');

    Route::delete('/delete', [UserController::class, 'delete'])->name('users.delete');

    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::prefix('profiles')->group(function () {

    Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');

    Route::get('/manage', [ProfileController::class, 'manage'])->name('profiles.manage');

    Route::get('/me', [ProfileController::class, 'self'])->name('profiles.self');

    Route::get('/show/{profile}', [ProfileController::class, 'show'])->name('profiles.show');

    Route::get('/{profile}/edit', [ProfileController::class, 'edit'])->name('profiles.edit');

    Route::post('/{profile}', [ProfileController::class, 'update'])->name('profiles.update');

    Route::delete('/delete', [ProfileController::class, 'delete'])->name('profiles.delete');
    
    Route::post('/{user}/deleteProfileImage', [ProfileController::class, 'deleteProfileImage'])->name('profiles.deleteProfileImage');

    Route::delete('/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');

    Route::post('/{user}/{profile}/follow', [ProfileController::class, 'follow'])->name('profiles.follow');

    Route::post('/{user}/{profile}/unfollow', [ProfileController::class, 'unfollow'])->name('profiles.unfollow');

    Route::get('/explore/search', [ProfileController::class, 'showSearch'])->name('profiles.search');
    
    Route::post('/explore/search', [ProfileController::class, 'showSearchResults'])->name('profiles.search');
});

/*
|--------------------------------------------------------------------------
| Posts Routes
|--------------------------------------------------------------------------
*/

Route::prefix('posts')->group(function () {

    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');

    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');

    Route::post('/', [PostController::class, 'store'])->name('posts.store');

    Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

    Route::patch('/{post}', [PostController::class, 'update'])->name('posts.update');

    Route::delete('/delete', [PostController::class, 'delete'])->name('posts.delete');

    Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/{post}/like', [PostController::class, 'like'])->name('posts.like');
});

/*
|--------------------------------------------------------------------------
| Comment Routes
|--------------------------------------------------------------------------
*/

Route::prefix('comments')->group(function () {

    Route::get('/', [CommentController::class, 'index'])->name('comments.index');

    // Route::get('/create', [CommentController::class, 'create'])->name('comments.create');

    // Route::get('/{comment}', [CommentController::class, 'show'])->name('comments.show');

    Route::post('/', [CommentController::class, 'store'])->name('comments.store');

    // Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');

    // Route::patch('/{comment}', [CommentController::class, 'update'])->name('comments.update');

    // Route::delete('/delete', [CommentController::class, 'delete'])->name('comments.delete');

    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});




