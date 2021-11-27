<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
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

Route::get('/search', [PostController::class, 'search'])->name('post.search');
Route::get('/', [PostController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('/new', [PostController::class, 'new']);
    Route::post('/new', [PostController::class, 'create']);
    Route::get('/edit/{postId}', [PostController::class, 'edit']);
    Route::put('/edit/{postId}', [PostController::class, 'update'])->name('update');
    Route::get('/delete/{postId}', [PostController::class, 'delete']);
    Route::delete('/delete/{postId}', [PostController::class, 'destroy'])->name('destroy');
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/name', [UserController::class, 'editName']);
    Route::post('/user/name', [UserController::class, 'updateName']);
    Route::get('/user/email', [UserController::class, 'editEmail']);
    Route::post('/user/email', [UserController::class, 'updateEmail']);
    Route::get('/user/password', [UserController::class, 'editPassword']);
    Route::post('/user/password', [UserController::class, 'updatePassword']);
});

Route::get('/{postId}', [PostController::class, 'show'])->name('post.show');
Route::get('/tag/{tagName}', [PostController::class, 'searchTag'])->name('post.searchTag');
