@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Manage Users</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{route('admin.user.create')}}" class="btn btn-primary">Add New User</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date Created</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @foreach($user->roles as $role)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td><a href="{{route('admin.user.edit', $user->id)}}">{{$user->name}}</a></td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->created_at->toFormattedDateString()}}</td>
                                    <td>{{$role->display_name}}</td>
                                    <td><a href="{{route('admin.user.edit', $user->id)}}" class="btn btn-primary">Edit</a></td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
