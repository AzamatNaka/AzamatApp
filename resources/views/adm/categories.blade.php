@extends('layouts.adm')

@section('title', "CATEGORIES PAGE")

@section('content')

    <h2>Categories Page</h2>
    <p>Type something in the input field to search the table for first names, last names or emails:</p>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Code</th>
            <th>Number of posts</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody id="myTable">
        @for($i=0; $i<count($categories); $i++)
            <tr>
                <th scope="row">{{$i+1}}</th>
                <td>{{$categories[$i]->name}}</td>
                <td>{{$categories[$i]->code}}</td>
                <td>{{count($categories[$i]->posts)}}</td>
                <td>
                    Edit
                </td>
                <td>
                    Delete
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
