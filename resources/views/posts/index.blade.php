@extends('layouts.app')

@section('title', "INDEX PAGE")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a class="btn btn-outline-primary mb-3" href="{{ route('posts.create') }}">Go to Create Page</a>
                @foreach($posts as $post)
                    <div class="card mb-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p class="card-text">{{$post->content}}</p>
                            <a href="{{route('posts.show', $post->id)}}" class="btn btn-primary mb-3">Read more</a>

                            <form action="{{route('posts.destroy', $post->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection









