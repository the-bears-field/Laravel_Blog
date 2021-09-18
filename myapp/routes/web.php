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
Route::get('/new', [PostController::class, 'new'])->middleware('auth');
Route::post('/new', [PostController::class, 'create'])->middleware('auth');
Route::get('/edit/{postId}', [PostController::class, 'edit'])->middleware('auth');
Route::post('/edit/{postId}', [PostController::class, 'update'])->middleware('auth');
Route::get('/user', [UserController::class, 'index'])->middleware('auth');
Route::get('/{postId}', [PostController::class, 'show'])->name('post.show');
