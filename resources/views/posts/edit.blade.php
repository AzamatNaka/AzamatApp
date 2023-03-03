<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Create a post</title>
</head>
<body>

    <a href="{{ route('posts.index') }}">Go to Index Page</a>

    <form action="{{ route('posts.update', $post->id) }}" method="post">
        @csrf
        @method('PUT')
        Title: <input type="text" name="title" value="{{$post->title}}"> <br>

        category: <select name="category_id" id="">
            @foreach($categories as $cat)
                <option @if ($post->category_id == $cat->id) selected @endif value="{{$cat->id}}">{{$cat->name}}</option>
            @endforeach
        </select> <br>

        Content: <textarea name="content" cols="30" rows="10">{{$post->content}}</textarea>
        <button type="submit">Update post</button>
    </form>

</body>
</html>
