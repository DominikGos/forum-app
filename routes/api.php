<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
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

Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['as' => 'users', 'prefix' => '/users/{id}'], function() {
        Route::put('', [UserController::class, 'update'])->name('.update');

        Route::delete('', [UserController::class, 'destroy'])->name('.destroty');
    });

    Route::group(['as' => 'forums', 'prefix' => '/forums'], function() {
        Route::post('/{forumId}/threads', [ThreadController::class, 'store'])->name('.threads.store');
    });

    Route::group(['as' => 'threads', 'prefix' => '/threads'], function() {
        Route::delete('/{id}', [ThreadController::class, 'destroy'])->name('.destroy');

        Route::put('/{id}', [ThreadController::class, 'update'])->name('.update');
    });
});

Route::group(['as' => 'users', 'prefix' => '/users'], function() {
    Route::get('', [UserController::class, 'index'])->name('.index');

    Route::get('/{id}', [UserController::class, 'show'])->name('.show');
});

Route::group(['as' => 'threads', 'prefix' => '/threads'], function() {
    Route::get('/{id}', [ThreadController::class, 'show'])->name('.show');

    Route::get('/{threadId}/replies', [ReplyController::class, 'index'])->name('.replies.index');
});

Route::group(['as' => 'forums', 'prefix' => '/forums'], function() {
    Route::get('', [ForumController::class, 'index'])->name('.index');

    Route::get('/{forumId}/threads', [ThreadController::class, 'index'])->name('.threads.index');
});

Route::group(['as' => 'tags', 'prefix' => 'tags'], function() {
    Route::get('', [TagController::class, 'index'])->name('.index');
});
