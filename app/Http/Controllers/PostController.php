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
    public function rate(Request $request, Post $post){
        $request->validate([
           'rating' => 'required|min:1|max:10'
        ]);
        $postRated = Auth::user()->postsRated()->where('post_id', $post->id)->first(); //осы кирип турган юзердын User modelдын ышиндеги postsRated деген функцияны шакыр и сонын ышиндеги связканы ыздейды где 'post_id' == $post->id (first() - деген ен бириншы турганды алып шыгады)
        if($postRated != null){
            Auth::user()->postsRated()->updateExistingPivot($post->id, ['rating' => $request->input('rating')]);
        }
        else{
            Auth::user()->postsRated()->attach($post->id, ['rating' => $request->input('rating')]); //attach типа используется вместо create
        }
        return back();
    }

    public function unrate(Post $post){
        $postRated = Auth::user()->postsRated()->where('post_id', $post->id)->first(); //осы кирип турган юзердын User modelдын ышиндеги postsRated деген функцияны шакыр и сонын ышиндеги связканы ыздейды где 'post_id' == $post->id (first() - деген ен бириншы турганды алып шыгады)
        if($postRated != null){
            Auth::user()->postsRated()->detach($post->id); //осы юзер багалаган посттын(где $post->id осындай) связкасын оширип тыстайды
//            $post->usersRated()->detach(); // осы $postтын барлык юзерлердин берген багаларын оширип тыстайды (неге барлык ойткени биз юзердын айдиын бермедик )
        }
        return back();
    }

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
        $this->authorize('create', Post::class);
        return view('posts.create', ['categories' => Category::all()]);
    }

    //save a post with title and content to DATABASE
    public function store(Request $req){
        $this->authorize('create', Post::class);
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

        $myRating = 0;
        if (Auth::check()){
            $postRated = Auth::user()->postsRated()->where('post_id', $post->id)->first();
            if($postRated != null)
                $myRating = $postRated->pivot->rating; //many to many связкада pivot дегенды колданамыз чтобы $postRatedтен ratingты алу ушин
        }

//        средний рейтинг
        $avgRating = 0;
        $sum = 0;
        $ratedUsers = $post->usersRated()->get(); // осы $postты багалаган юзерлерды(usersRated() деген Post modelдын ышиндеги функция) алып шыгады (get() деген массивты алып шыгады то есть барлык результатты)
        foreach ($ratedUsers as $ru){
            $sum += $ru->pivot->rating;
        }
        if (count($ratedUsers) > 0)
            $avgRating = $sum/count($ratedUsers);
        return view('posts.show', ['post' => $post, 'categories' => Category::all(), 'myRating' => $myRating, 'avgRating' => $avgRating]);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', ['post' => $post, 'categories' => Category::all()]);
    }


    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
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
        // authenticatation (authenticate) - аутентикация то есть просто киру логин парольмен
        // authorization (authorize) - авторизация сенде права бар ма жок соны тексеру (мысалга бирденени косуга или оширу дегендей)
        $this->authorize('delete', $post); // $this->authorize проверяет политику то есть он отправляет в PostPolicy в функцию delete $post на проверку
        $post->delete();
        return redirect()->route('posts.index');
    }
}
