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
                            <li class="breadcrumb-item active" aria-current="page">Create User</li>
                        </ol>
                    </nav>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{route('admin.user.store')}}" class="user-setting" method="post">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="form-group">
                                <input class="form-control" type="text" name="first_name" placeholder="First Name *" id="fname" required>
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="text" name="last_name" placeholder="Last Name *" id="lname" required>
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Email *" id="email" required>
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="Password *" id="password" required>
                            </p>
                            <p class="form-group">
                                <select name="user_city" class="form-control" required>
                                    <option value="Dubai">Dubai</option>
                                </select>
                            </p>
                            <p class="form-group">
                                <select name="role" class="form-control custom-select d-block" required>
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
    </section>
</main>
@endsection
