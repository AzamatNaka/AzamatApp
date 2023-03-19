<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth2\RegisterController;
use App\Http\Controllers\Auth2\LoginController;
use App\Http\Controllers\Adm\UserController;
use App\Http\Controllers\Adm\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Adm\AdminController;

use App\Models\User;
use App\Models\Post;

//тестовые запросы
Route::get('/test', function (){
//    Auth::user() == User::find(1) (тут айдидын орнында кирип турган юзердин айдиы жазылады)
//    $ratedPosts = User::find(1)->postsRated()->get();
//    dd($ratedPosts[1]->pivot->rating); // чтобы many to many связкадагы таблиуадан(user_postтагы) rating деген столбецтегы данныйды алу ушин бириншы ->pivot потом ->rating
//    dd($ratedPosts[1]->content); // ал просто

//    $usersRated = Post::find(2)->usersRated()->get();
//    dd($usersRated[0]->email);
});


Route::get('/', function (){
    return redirect()->route('posts.index');
});

Route::middleware('hasrole:moderator')->group(function () {
    // moderator kiretin routetar
});

Route::middleware('auth')->group(function (){
//    Route::resource('posts', PostController::class)->only('create', 'edit', 'store', 'update', 'destroy');
    Route::resource('posts', PostController::class)->except('index', 'show');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('/comments', CommentController::class)->only('store', 'update', 'destroy'); // for comment here use only store, update, destroy
    Route::post('/posts/{post}/rate', [PostController::class, 'rate'])->name('posts.rate');
    Route::post('/posts/{post}/unrate', [PostController::class, 'unrate'])->name('posts.unrate');

    //карзинага тыгу
    Route::post('/cart/{post}/putToCart', [CartController::class, 'putToCart'])->name('cart.puttocart');
    Route::post('/cart/{post}/deleteFromCart', [CartController::class, 'deleteFromCart'])->name('cart.deletefromcart');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'buy'])->name('cart.buy');


    //    prefix('adm') это для добавления к url слово adm (например тогда будет /adm/users/)
//    as('adm.') это для добавления к впереди name routeта слово adm. (например тогда будет adm.users.index)
    Route::prefix('adm')->as('adm.')->middleware('hasrole:admin, moderator')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
//        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::put('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::put('/users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
//        Route::get('/adm/users/search', [UserController::class, 'index'])->name('adm.users.search'); // for search
//        Route::get('/adm/posts', [UserController::class, 'index'])->name('adm.posts');
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

        Route::get('/adm/cart', [AdminController::class, 'cart'])->name('cart.index');
        Route::put('/adm/cart/{cart}/confirm', [AdminController::class, 'confirm'])->name('cart.confirm');
    });
});

Route::resource('posts', PostController::class)->only('index', 'show'); //for posts

Route::get('/posts/category/{category}', [PostController::class, 'postsByCategory'])->name('posts.category'); //->middleware('hasrole:admin'); //->middleware('auth');//middleware делает проверку а именно auth то есть пользователь должен залогиниться //for posts by category

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
