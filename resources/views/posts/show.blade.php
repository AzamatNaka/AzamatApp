@extends('layouts.app')

@section('title', "SHOW PAGE")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <a class="btn btn-outline-primary mb-3" href="{{ route('posts.index') }}">Go to Index Page</a>

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{{$post->content}}</p>

                        <a class="btn btn-outline-success" style="width: 100%" href="{{route('posts.edit', $post->id)}}">Edit</a>
                    </div>
                </div>

            </div>

            <div class="col-md-10 mt-3">
                <form action="{{ route('comments.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="commentInput">Content</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="commentInput" name="comment" rows="3"></textarea>
                        <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}" />
                        @error('comment')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <button class="btn btn-outline-success" type="submit">Save comment</button>
                    </div>
                </form>
            </div>

{{--            @if($comment != null)--}}
                @foreach($post->comments as $com)
                    <div class="col-md-10 mt-3 shadow-sm p-2 bg-white d-inline-flex justify-content-between">
                        <p class="mr-5">{{ $com->comment }}</p>
                        <small>{{$com->created_at}} | author: {{$com->user->name}}</small>
                        <div class="btn-group btn-sm d-inline-flex align-items-center">

{{--                            <a class="btn btn-outline-success btn-sm mx-3" style="height: 90%" href="{{route('comments.edit', $com->id)}}">Edit</a>--}}

                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$com->id}}">
                                Edit
                            </button>

                            <!-- The Modal -->
                            <div class="modal fade" id="{{$com->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Comment</h4>
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="{{ route('comments.update', $com->id) }}" method="post">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-group">
                                                    <label for="commentInput">Content</label>
                                                    <textarea class="form-control @error('comment') is-invalid @enderror" id="commentInput" name="comment" rows="3">{{$com->comment}}</textarea>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <button class="btn btn-outline-success" type="submit">Update post</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Modal footer -->
{{--                                        <div class="modal-footer">--}}
{{--                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                                        </div>--}}

                                    </div>
                                </div>
                            </div>



                            <form action="{{route('comments.destroy', $com->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger mx-1" style="height: 80%" type="submit">Delete</button>
                            </form>
                        </div>

                    </div>
                @endforeach
{{--            @endif--}}

        </div>
    </div>
@endsection

