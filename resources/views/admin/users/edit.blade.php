@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User {{$user->name}}</div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <a href="{{route('admin.user.delete', $user->id)}}" class="btn btn-danger" onclick="event.preventDefault(); var r = confirm('Are you sure you want to delete this user ?'); if (r == true) {document.getElementById('delete-form-{{$user->id}}').submit();}">Delete User</a>
                    <a href="{{route('admin.user.create')}}" class="btn btn-primary">Add New User</a>
                    <br>
                    <form action="{{route('admin.user.update', $user->id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="group-control">
                                <input class="input-control" type="text" name="name" placeholder="Name" id="name" value="{{$user->name}}" />
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="text" name="username" placeholder="username" id="username" value="{{$user->username}}" />
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="email" name="email" placeholder="email" id="email" value="{{$user->email}}" />
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="password" name="password" placeholder="password" id="password" />
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="text" name="phone" placeholder="phone" id="phone" value="{{$user->phone}}" />
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="file" name="profile_pic_url" />
                            </p>
                            <p class="group-control">
                                <select name="role">
                                    @foreach ($roles as $role)
                                        @foreach ($user->roles as $user_role)
                                            <option value="{{$role->id}}" {{$user_role->id == $role->id ? 'selected' : ''}}>{{$role->display_name}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Submit" />
                        </div>
                        
                    </form>
                    @if($user->profile_pic_url)
                        <img src="{{asset($user->profile_pic_url)}}" />
                        <br>
                    @endif
                    This user have {{$user->honeycombs ? $user->honeycombs : 0}} Honycombs points

                    <form id="delete-form-{{$user->id}}" action="{{route('admin.user.delete', $user->id)}}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
