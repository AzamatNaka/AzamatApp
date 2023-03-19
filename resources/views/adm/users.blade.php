@extends('layouts.adm')

@section('title', "USERS PAGE")

@section('content')

    <h2>Users Page</h2>
    <p>Type something in the input field to search the table for first names, last names or emails:</p>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Bann</th>
            <th>Edit Role</th>
        </tr>
        </thead>
        <tbody id="myTable">
        @for($i=0; $i<count($users); $i++)
            <tr>
                <th scope="row">{{$i+1}}</th>
                <td>{{$users[$i]->name}}</td>
                <td>{{$users[$i]->email}}</td>
                <td>{{$users[$i]->role->name}}</td>
                <td>
                    <form action="
                    @if($users[$i]->is_active)
                        {{route('adm.users.ban', $users[$i]->id)}}
                    @else
                        {{route('adm.users.unban', $users[$i]->id)}}
                    @endif
                    " method="post">
                        @csrf
                        @method('PUT')
                        <button class="btn {{ $users[$i]->is_active ? 'btn-danger' : 'btn-success'}}" type="submit">
                            @if($users[$i]->is_active)
                                Ban
                            @else
                                Unban
                            @endif
                        </button>
                    </form>
                </td>
                <td>
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$users[$i]->id}}">
                        Edit Role
                    </button>

                    <!-- The Modal -->
                    <div class="modal fade" id="{{$users[$i]->id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Role</h4>
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form action="{{ route('adm.users.update', $users[$i]->id) }}" method="post">
                                        @csrf
                                        @method('PUT')

                                            <div class="form-group">
                                                <label for="userRoleInput">User: {{ $users[$i]->name }} | Email: {{ $users[$i]->email }}</label>
                                                <select class="form-control @error('role_id') is-invalid @enderror" id="userRoleInput" name="role_id">
                                                    @foreach($roles as $role)
                                                        <option @if ($role->id == $users[$i]->role_id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                                @enderror
                                            </div>


                                        <div class="form-group mt-3">
                                            <button class="btn btn-outline-success" type="submit">Update role</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
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
