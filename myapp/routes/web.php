<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [PostController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('/new', [PostController::class, 'new']);
    Route::post('/new', [PostController::class, 'create']);
    Route::get('/edit/{postId}', [PostController::class, 'edit']);
    Route::post('/edit/{postId}', [PostController::class, 'update']);
    Route::get('/delete/{postId}', [PostController::class, 'delete']);
    Route::post('/delete/{postId}', [PostController::class, 'destroy']);
    Route::get('/user', [UserController::class, 'index']);
});

Route::get('/{postId}', [PostController::class, 'show'])->name('post.show');
