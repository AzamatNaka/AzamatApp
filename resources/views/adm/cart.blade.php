@extends('layouts.adm')

@section('title', "CART PAGE")

@section('content')

    <h2>CART Page</h2>
    <p>Type something in the input field to search the table for first names, last names or emails:</p>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>title</th>
            <th>name</th>
            <th>color</th>
            <th>number</th>
            <th>status</th>
            <th>#</th>
        </tr>
        </thead>
        <tbody id="myTable">
        @for($i=0; $i<count($postInCart); $i++)
            <tr>
                <th scope="row">{{$i+1}}</th>
                <td>{{$postInCart[$i]->post->title}}</td>
                <td>{{$postInCart[$i]->user->name}}</td>
                <td>{{$postInCart[$i]->color}}</td>
                <td>{{$postInCart[$i]->number}}</td>
                <td>{{$postInCart[$i]->status}}</td>
                <td>
                    <form action="{{route("adm.cart.confirm", $postInCart[$i]->id)}}" method="post">
                        @csrf
                        @method("PUT")
                        <button type="submit">Confirm order</button>
                    </form>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>


    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
