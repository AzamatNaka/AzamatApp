<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required',
            'post_id' => 'required|numeric|exists:posts,id'
        ]);
//        Comment::create($validated);
        Auth::user()->comments()->create($validated);
//        dd($validated);
//        $post = Post::find($request->post_id);

//        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
//            ->select('comments.*')
//            ->get();

//        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
//            ->where('posts.id', '=', $post->id)
//            ->select('comments.*')
//            ->get();
        return back()->with('message', 'Comment save successfully!');
//        return redirect()->route('posts.show', ['post' => $post, 'categories' => Category::all()])->with('message', 'Comment save successfully!');
    }

    public function show(Comment $comment)
    {
        //
    }

    public function edit(Comment $comment)
    {
        //
    }

    public function update(Request $request, Comment $comment)
    {
//        dd($request);
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'comment' => 'required',
        ]);

        $comment->update($validated);

//        $post = Post::find($comment->post_id);
//        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
//            ->where('posts.id', '=', $post->id)
//            ->select('comments.*')
//            ->get();
        return back()->with('message', 'Comment changed successfully!');
//        return redirect()->route('posts.show', ['post' => $post, 'categories' => Category::all()])->with('message', 'Comment changed successfully!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('message', 'Comment deleted successfully!');
//        $post = Post::find($comment->post_id);
//        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
//            ->where('posts.id', '=', $post->id)
//            ->select('comments.*')
//            ->get();
//
//        return redirect()->route('posts.show', ['post' => $post, 'categories' => Category::all(), 'comment' => $comment])->with('message', 'Comment deleted successfully!');
    }
}
