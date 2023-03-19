@extends('layouts.app')

@section('title', 'CART PAGE')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Number</th>
                        <th>Color</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($postInCart as $post)
                        <tr>
                            <td>{{$post->title}}</td>
                            <td>{{$post->pivot->number}}</td>
                            <td>{{$post->pivot->color}}</td>
                            <td>{{$post->pivot->status}}</td>
                            <td>
                                <form action="{{route('cart.deletefromcart', $post->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <form action="{{route('cart.buy')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success">Buy all</button>
                </form>
            </div>
        </div>
    </div>
@endsection
