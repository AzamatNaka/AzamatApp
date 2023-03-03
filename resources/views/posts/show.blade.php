@extends('layouts.app')

@section('title', "SHOW PAGE")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <a class="btn btn-outline-primary mb-2" href="{{ route('posts.index') }}">Go to Index Page</a>

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{{$post->content}}</p>
                        <a href="{{route('posts.show', $post->id)}}" class="btn btn-primary">Read more</a>

                        <a class="btn btn-outline-success" href="{{route('posts.edit', $post->id)}}">Edit</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

