<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function postsByCategory(Category $category)
    {
        return view('posts.index', ['posts' => $category->posts, 'categories' => Category::all()]);
    }

//return view with all posts
    public function index(){
        $allPosts = Post::all();
        return view('posts.index', ['posts' => $allPosts, 'categories' => Category::all()]);
    }

    //return view with a form create
    public function create(){
        return view('posts.create', ['categories' => Category::all()]);
    }

    //save a post with title and content to DATABASE
    public function store(Request $req){
//        return $req->content;
        Post::create([
            'title' => $req->title,
            'content' => $req->content,
            'category_id' => $req->category_id,
        ]);
        return redirect()->route('posts.index');
    }

    //return view with a form create
    public function show(Post $post){
//        $post = Post::find($id); == Post $post
//        $cat = $post->category;
//        dd($cat->code);
        return view('posts.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post, 'categories' => Category::all()]);
    }


    public function update(Request $request, Post $post)
    {
        $post->update([
            'title' => $request->title,     //$request->title == $request->input('title')
            'content' => $request->content, //$request->content == $request->input('content')
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('posts.index');
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
