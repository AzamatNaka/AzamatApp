<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with('posts')->get();
        return view('adm.categories', ['categories' => $categories]);
    }

//    for cart
    public function cart(){ //бул функция барлык cartтарды алып шыгады где статус ордередке тен
        $postsInCart = Cart::where('status', 'ordered')->with(['post', 'user'])->get();
        return view('admin.cart', ['postsInCart' => $postsInCart]);
    }
}
