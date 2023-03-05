<?php

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth2\RegisterController;
use App\Http\Controllers\Auth2\LoginController;

Route::get('/', function (){
    return redirect()->route('posts.index');
});

Route::middleware('auth')->group(function (){
//    Route::resource('posts', PostController::class)->only('create', 'edit', 'store', 'update', 'destroy');
    Route::resource('posts', PostController::class)->except('index', 'show');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('/comments', CommentController::class)->only('store', 'update', 'destroy'); // for comment here use only store, update, destroy
});

Route::resource('posts', PostController::class)->only('index', 'show'); //for posts

Route::get('/posts/category/{category}', [PostController::class, 'postsByCategory'])->name('posts.category'); //->middleware('auth');//middleware делает проверку а именно auth то есть пользователь должен залогиниться //for posts by category

//Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/register', [RegisterController::class, 'create'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'create'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

//Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
//Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
//Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
//Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
