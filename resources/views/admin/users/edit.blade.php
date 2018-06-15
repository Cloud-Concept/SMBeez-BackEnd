@extends('layouts.admin')

@section('content')
<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.superadmin-sidebar')
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit User {{$user->first_name . " " . $user->last_name}}</li>
                        </ol>
                    </nav>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.user.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add New User</a></div>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); var r = confirm('Are you sure you want to delete this user ?'); if (r == true) {document.getElementById('delete-form-{{$user->id}}').submit();}"><i class="fa fa-minus-circle fa-3x" aria-hidden="true"></i> Delete This User</a></div>
                    <br>
                    @if($user->profile_pic_url && file_exists(public_path('/') . $user->profile_pic_url))
                        <img src="{{asset($user->profile_pic_url)}}" />
                        <br>
                    @endif
                    <br>
                    <p>This user have {{$user->honeycombs ? $user->honeycombs : 0}} Honycombs points</p>
                    <br>
                    <form action="{{route('admin.user.update', $user->username)}}" class="user-setting" role="form" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="form-group">
                                <input class="form-control" type="text" name="first_name" placeholder="First Name" id="fname" value="{{$user->first_name}}" required/>
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="text" name="last_name" placeholder="Last Name" id="lname" value="{{$user->last_name}}" required/>
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="email" id="email" value="{{$user->email}}" />
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="password" id="password" />
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="text" name="phone" placeholder="phone" id="phone" value="{{$user->phone}}" />
                            </p>
                            <p class="form-group">
                                <label class="custom-file">
                                    <input type="file" id="profile_pic_url" name="profile_pic_url" class="form-control custom-file-input" accept=".jpg, .png, .jpeg"> 
                                    <span class="custom-file-control" data-label="Profile Picture"></span>
                                </label>
                            </p>
                            <p class="form-group">
                                <select name="role" class="form-control custom-select d-block">
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
                    <form id="delete-form-{{$user->id}}" action="{{route('admin.user.delete', $user->username)}}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
