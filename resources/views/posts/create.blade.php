<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Create a post</title>
</head>
<body>

    <a href="{{ route('posts.index') }}">Go to Index Page</a>

    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        Title: <input type="text" name="title"> <br>

        category: <select name="category_id" id="">
            @foreach($categories as $cat)
                <option value="{{$cat->id}}">{{$cat->name}}</option>
            @endforeach
        </select> <br>

        Content: <textarea name="content" cols="30" rows="10"></textarea>
        <button type="submit">Save post</button>
    </form>

</body>
</html>
