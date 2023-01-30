<?php

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



Route::group(['as' => 'users', 'prefix' => '/users'], function() {
    Route::get('', [UserController::class, 'index'])->name('.index');

    Route::get('/{id}', [UserController::class, 'show'])->name('.show');
});

Route::group(['as' => 'threads', 'prefix' => '/threads'], function() {
    
    Route::group(['prefix' => '/{id}'], function() {
        Route::get('', [ThreadController::class, 'show'])->name('.show');

        Route::group(['as' => '.replies', 'prefix' => '/replies'], function() {
            Route::get('', [ReplyController::class, 'index'])->name('.index');
        });
    });
});

Route::group(['as' => 'forums', 'prefix' => '/forums'], function() {
    Route::get('', [ForumController::class, 'index'])->name('.index');
});

Route::group(['as' => 'tags', 'prefix' => 'tags'], function() {
    Route::get('', [TagController::class, 'index'])->name('.index');
});
