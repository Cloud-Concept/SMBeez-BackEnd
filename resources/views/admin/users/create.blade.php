@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create New User</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{route('admin.user.store')}}" method="post">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="group-control">
                                <input class="input-control" type="text" name="name" placeholder="Name" id="name">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="text" name="username" placeholder="username" id="username">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="email" name="email" placeholder="email" id="email">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="password" name="password" placeholder="password" id="password">
                            </p>
                            <p class="group-control">
                                <select name="role">
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{$role->display_name}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
