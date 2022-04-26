<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/tesemail', [BlogController::class,'tesEmail']);

Route::get('/', [BlogController::class ,'landingPage']);
Route::get('home',)->middleware(['auth','verified']);
Route::get('/tag/{tags}', [BlogController::class, 'getPostByTag']);
Route::get('/category/{category}', [BlogController::class, 'getPostByCategory']);
Route::get('/sitemap',[SitemapsController::class, 'post']);
Route::get('/user/{id}', [BlogController::class, 'getUser']);
Route::get('/{slug}', [BlogController::class, 'getPostBySlug']);    

Route::middleware(['auth','verified','checkrole'])->group(function(){
    Route::get('/home', [DashboardController::class, 'index']);
    Route::get('/home/user', [UserController::class, 'index']);
    Route::get('home/user/{id}/edit',[UserController::class, 'edit']);
    Route::delete('home/user/{id}', [UserController::class, 'destroy']);
    Route::get('/home/follow', [FollowersController::class, 'index']);
    Route::get('home/profile', [UserController::class, 'profile']);
    Route::get('home/post', [PostController::class, 'index']);
    Route::get('home/verifikasi', [PostController::class, 'verifikasi']);
    Route::delete("home/post{id}", [PostController::class, 'deletePost']);
    Route::get('home/createpost', [PostController::class, 'createPost']);
    Route::get('home/post/{id}/edit',[PostController::class, 'editPost']);
    Route::post('home/savepost', [PostController::class, 'savePost'])->name('savepost');
    Route::delete('home/post/{id}', [PostController::class, 'deletePost']);
    Route::get('/home/settings', [DashboardController::class,'settings']);
    Route::get('/home/settings/{id}/edit', [DashboardController::class, 'editSettings']);

    Route::middleware(['xss.sanitizer'])->group(function(){
        Route::resource('/home/komentar', CommentController::class);
        Route::put('/home/user/{id}', [UserController::class, 'update']);
        Route::resource('/home/kategori', CategoryController::class);
        Route::put('home/post/{id}', [PostController::class, 'updatePost']);
        Route::put('home/settings/{id}', [DashboardController::class, 'updateSettings']);
        Route::post('/komen_artikel/{postid}', [BlogController::class, 'komenArtikel']);
        Route::post('/reply_komen/{commentid}', [BlogController::class, 'replyKomen']);
        Route::post('/delete_komen/{commentid}', [BlogController::class, 'deleteKomen']);
        Route::post('/actionpost/{postid}/{fromuser?}', [BlogController::class,'actionPost']);
    });
});