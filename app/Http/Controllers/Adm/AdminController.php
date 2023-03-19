<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;

class AdminController extends Controller
{
    public function cart(){
        $postInCart = Cart::where('status', 'ordered')->with(['post', 'user'])->get();
        return view('adm.cart', ['postInCart' => $postInCart]);
    }

    public function confirm(Cart $cart){
        $cart->update([
            'status' => 'confirmed'
        ]);

        return back();
    }
}
