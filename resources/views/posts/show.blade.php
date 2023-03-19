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
                        @can('update', $post)
                            <a class="btn btn-outline-success" style="width: 100%" href="{{route('posts.edit', $post->id)}}">Edit</a>
                        @endcan
                    </div>
                </div>

{{--                средний рейтинг--}}
                <div class="row mt-3">
                    <div class="col-md-6">
                        @if($avgRating != 0)
                            <div class="card p-2 mb-3">
                                <h5 class="mb-2"> Rating: {{round($avgRating, 1)}}</h5>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $avgRating*10 }}%" aria-valuenow="{{ $avgRating*10 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>



                {{--                рейтинг беру--}}
                <div class="row mt-3">
                    <div class="col-md-6">
                        @auth() {{--логин жасаган юзерлер гана коре алады--}}
                            <form action="{{ route('posts.rate', $post->id) }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <select class="form-select" name="rating">
                                        @for($i=0; $i<=10; $i++)
                                            <option {{ $myRating == $i ? 'selected' : ''}} value="{{$i}}">
                                                {{ $i==0 ? 'Not rated' : $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="btn btn-primary">Rate</button>
                                </div>
                            </form>
                        {{--                отмена рейтинга то есть рейтингынды алып тыстау--}}
                            <form action="{{ route('posts.unrate', $post->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Unrate</button>
                            </form>
                        @endauth
                    </div>
                </div>

{{--                               start cart--}}
                @auth()
                    <form action="{{ route('cart.puttocart', $post->id) }}" method="post" class="form-inline mt-3">
                        @csrf
                        <div class="form-group">
                            <label for="color" class="mr-2">Color:</label>
                            <select name="color" id="color" class="form-control mr-2">
                                <option value="Blue">Blue</option>
                                <option value="Red">Red</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="number" class="mr-2">Quantity:</label>
                            <input type="number" name="number" id="number" class="form-control mr-2" placeholder="1" min="1" max="100"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                @endauth
{{--                               end cart--}}


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
                            @can('update', $com)
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$com->id}}">
                                Edit
                            </button>
                            @endcan
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


                            @can('delete', $com)
                                <form action="{{route('comments.destroy', $com->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger mx-1" style="height: 80%" type="submit">Delete</button>
                                </form>
                            @endcan
                        </div>

                    </div>
                @endforeach
{{--            @endif--}}

        </div>
    </div>
@endsection

