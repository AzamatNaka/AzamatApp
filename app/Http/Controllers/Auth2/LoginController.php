<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class LoginController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function login(Request $request){
        if(Auth::check()){
            return redirect()->intended('/posts'); //intended куда хотел изначално
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($validated)) { //attempt базадан тексереди validatedтеги данный бар ма деп иа болса логин кылып киргизеди
            return redirect()->intended('/posts');
        }

        return back()->withErrors('Incorrect email or password');
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('posts.index');
    }
}
