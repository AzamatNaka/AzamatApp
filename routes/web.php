<?php

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function (){
    return redirect()->route('posts.index');
});
Route::resource('posts', PostController::class);

Route::get('/posts/category/{category}', [PostController::class, 'postsByCategory'])->name('posts.category');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('comments', CommentController::class);
//Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');



//Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
//Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
//Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
//Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
