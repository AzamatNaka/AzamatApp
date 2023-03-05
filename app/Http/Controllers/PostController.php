<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function postsByCategory(Category $category)
    {
        $category->load('posts.user');
//        dd($category);
        return view('posts.index', ['posts' => $category->posts, 'categories' => Category::all()]);
    }

//return view with all posts
    public function index(){
//        $allPosts = Post::all(); //get() деген запрос жиберу егерде пост деген класс болса with деп жазылады (бул астында турган кодка арналган кыска тусиниктеме)
//        $allPosts = Post::with('comments.user')->get(); // бириншы барлык посттарды коментарилермен бирге алып шык(comments деген post model дегеннын функциясы) потом сол коментарилерды жазган юзерлерди алып шык(user деген comment modelдын функциясы)
        $allPosts = Post::with('user')->get(); //барлык посттарды алып шык и сол постты жазган юзерлермен бирге(user Post Modelдын ышындеги функция)
        return view('posts.index', ['posts' => $allPosts, 'categories' => Category::all()]);
    }

    //return view with a form create
    public function create(){
        return view('posts.create', ['categories' => Category::all()]);
    }

    //save a post with title and content to DATABASE
    public function store(Request $req){

        $validated = $req->validate([
            'title' => 'required|max:255', //unique:posts
            'content' => 'required',
            'category_id' => 'required|numeric|exists:categories,id'
        ]);
//        dd(Auth::user()->posts); //осы кирип турган юзердин посттары
//        Post::create($validated + ['user_id' => Auth::user()->id]);
        Auth::user()->posts()->create($validated); // осы юзердин посттарынын касына validatedтеги посттарды косып создать ет // осы жердеги posts деген фукция user modelдеги функция
        return redirect()->route('posts.index')->with('message', 'Post save successfully!');
    }

    //return view with a form create
    public function show(Post $post){
//        $post = Post::find($id); == Post $post
//        $cat = $post->category;
//        dd($cat->code);

//        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
//            ->where('posts.id', '=', $post->id)
//            ->select('comments.*')
//            ->get();
//        $comment = $post->comments;
        $post->load('comments.user'); // бул жерде post деген обект кеп турган ушин with дын орнына load деп жазамыз бул тура $allPosts = Post::with('comments.user')->get(); осы сиякты запрос
        return view('posts.show', ['post' => $post, 'categories' => Category::all()]);
    }

    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post, 'categories' => Category::all()]);
    }


    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255', //unique:posts
            'content' => 'required',
            'category_id' => 'required|numeric|exists:categories,id'
        ]);

        $post->update($validated);

//        $post->update([
//            'title' => $request->title,     //$request->title == $request->input('title')
//            'content' => $request->content, //$request->content == $request->input('content')
//            'category_id' => $request->category_id,
//        ]);

        return redirect()->route('posts.index')->with('message', 'Post updated successfully!');
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
