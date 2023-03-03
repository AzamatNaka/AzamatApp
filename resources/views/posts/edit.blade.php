@extends('layouts.app')

@section('title', "EDIT PAGE")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <a class="btn btn-outline-primary mb-3" href="{{ route('posts.index') }}">Go to Index Page</a>

                <form action="{{ route('posts.update', $post->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="titleInput">Title</label>
                        <input type="text" name="title" value="{{$post->title}}" class="form-control @error('title') is-invalid @enderror" id="titleInput" placeholder="Enter title">
                        @error('title')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contentInput">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="contentInput" name="content" rows="3">{{$post->content}}</textarea>
                        @error('content')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categoryInput">Category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="categoryInput" name="category_id">
                            @foreach($categories as $cat)
                                <option @if ($post->category_id == $cat->id) selected @endif value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <button class="btn btn-outline-success" type="submit">Update post</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

