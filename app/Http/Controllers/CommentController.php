<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

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
        Comment::create($validated);
//        dd($validated);
        $post = Post::find($request->post_id);

//        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
//            ->select('comments.*')
//            ->get();

        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
            ->where('posts.id', '=', $post->id)
            ->select('comments.*')
            ->get();

        return redirect()->route('posts.show', ['post' => $post, 'categories' => Category::all(), 'comment' => $comment])->with('message', 'Comment save successfully!');
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
        $validated = $request->validate([
            'comment' => 'required',
        ]);

        $comment->update($validated);

        $post = Post::find($comment->post_id);
        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
            ->where('posts.id', '=', $post->id)
            ->select('comments.*')
            ->get();

        return redirect()->route('posts.show', ['post' => $post, 'categories' => Category::all(), 'comment' => $comment])->with('message', 'Comment changed successfully!');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        $post = Post::find($comment->post_id);
        $comment = Comment::join('posts', 'comments.post_id', '=', 'posts.id')
            ->where('posts.id', '=', $post->id)
            ->select('comments.*')
            ->get();

        return redirect()->route('posts.show', ['post' => $post, 'categories' => Category::all(), 'comment' => $comment])->with('message', 'Comment deleted successfully!');
    }
}
