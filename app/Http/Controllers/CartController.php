<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index(){
        $postsInCart = Auth::user()->postsWithStatus('in_cart')->get();
        return view('cart.index', ['postInCart' => $postsInCart]);
    }

    public function buy(){
        $ids = Auth::user()->postsWithStatus("in_cart")->allRelatedIds(); //allRelatedIds осы функция тек айдиларды(посттын статусы ин_карт деп жаткан барлык посттардын айдиы) массив туринде алып береди
//        dd($ids); // посттын айдиы
        foreach ($ids as $id){
            Auth::user()->postsWithStatus("in_cart")->updateExistingPivot($id, ['status' => 'ordered']);
        }
        return back();
    }

    public function putToCart(Request $request, Post $post){
        $postsInCart = Auth::user()->postsWithStatus("in_cart")->where('post_id', $post->id)->first();
//        dd($postsInCart);
        if($postsInCart != null)
            Auth::user()->postsWithStatus("in_cart")->updateExistingPivot($post->id,
            ['color' => $request->input('color'),
                'number' => $postsInCart->pivot->number+$request->input('number')]);
        else
//            dd($request->number);
            Auth::user()->postsBought()->attach($post->id,
                ['number' => $request->input('number'),
                'color' => $request->input('color')]);
        return back();
    }

    public function deleteFromCart(Post $post){
        $postsBought = Auth::user()->postsWithStatus("in_cart")->where('post_id', $post->id)->first();

        if($postsBought != null)
            Auth::user()->postsWithStatus("in_cart")->detach($post->id);
//            Auth::user()->postsWithStatus("in_cart")->detach(); осы жерде если айдиды указать етпесе то detach() барин оширип тыстайды
        return back();
    }
}
