@extends('layouts.app')

@section('title', "INDEX PAGE")

@section('content')
    <div class="container">
        <div class="row">
            <a class="btn btn-outline-primary mb-3" href="{{ route('posts.create') }}">Go to Create Page</a>
            <div class="d-inline-flex justify-content-around align-items-center flex-wrap">
                @foreach($posts as $post)
                    <div class="card mb-3" style="width: 15rem;">
                        <div class="card-body">
                            <h5 class="card-title"><h3>{{$post->title}}</h3> <small>Author: {{ $post->user->name }}</small></h5>
                            <p class="card-text">{{$post->content}}</p>
                            <div class="d-inline-flex justify-content-between" style="width: 100%">
                                <a href="{{route('posts.show', $post->id)}}" class="btn btn-primary mb-3">Read more</a>

                                <form action="{{route('posts.destroy', $post->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection









