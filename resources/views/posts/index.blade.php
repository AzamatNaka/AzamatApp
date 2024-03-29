@extends('layouts.app')

@section('title', "INDEX PAGE")

@section('content')
    <div class="container">
        <div class="row">
            @can('create', \App\Models\Post::class)
                <a class="btn btn-outline-primary mb-3" href="{{ route('posts.create') }}">Go to Create Page</a>
            @endcan
            <div class="d-inline-flex justify-content-around align-items-center flex-wrap">
                @foreach($posts as $post)
                    <div class="card mb-3" style="width: 30%;">
                        <div class="card-body">
                            <h5 class="card-title"><h3>{{$post->title}}</h3> <small>Author: {{ $post->user->name }}</small></h5>
                            <p class="card-text">{{$post->content}}</p>

                            {{--                средний рейтинг--}}
                            <div hidden="hidden">
                            {{      $avgRating = 0,
                                    $sum = 0, }}
                                    @foreach ($post->usersRated as $ru)
                                        {{$sum += $ru->pivot->rating}}
                                    @endforeach
                                    @if ($sum > 0)
                                        {{$avgRating = $sum/count($post->usersRated)}}
                                    @endif
                            </div>

                            @if($avgRating > 0)
                                <p><strong>Rating: {{round($avgRating, 1)}}</strong></p>
                            @endif

                            <div class="d-inline-flex justify-content-between" style="width: 100%">
                                <a href="{{route('posts.show', $post->id)}}" class="btn btn-primary mb-3">Read more</a>

                               @can('delete', $post) {{--  //проверяет политику который написан в Policies -> PostPolicy--}}
                                    <form action="{{route('posts.destroy', $post->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection









