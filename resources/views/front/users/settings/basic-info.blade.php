@extends('layouts.inner')

@section('content')
<nav class="dashboard-nav navbar navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i></button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent2">
        @include ('layouts.dashboard-menu')
    </div>
</nav>
<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include ('layouts.profile-edit-sidebar')
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                    <div class="alert alert-secondary alert-dismissible fade show my-4" role="alert">
                        <h3>You are subscribed to our free plan <a href="" class="pull-right text-capitalize">upgrade</a></h3>
                        <p>Upgrade your plan before 26/9/2018 and enjoy lots of amazing features</p>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <form action="{{route('front.user.update_basic', $user->username)}}" method="POST" class="user-setting" role="form" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="">Full Name</label>
                                    <div class="d-flex"><input type="text" name="name" class="form-control" placeholder="Full Name" value="{{$user->name}}"> <a href="" class="edit-form"><i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i></a></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Email Address</label>
                                    <div class="d-flex"><input type="text" name="email" class="form-control" placeholder="Email" value="{{$user->email}}"> <a href="" class="edit-form"><i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i></a></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <div class="d-flex"><input type="password" name="password" class="form-control" placeholder="Password"> <a href="" class="edit-form"><i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i></a></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Mobile Number</label>
                                    <div class="d-flex"><input type="text" name="phone" class="form-control" placeholder="Phone" value="{{$user->phone}}"> <a href="" class="edit-form"><i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i></a></div>
                                </div>
                                <div class="form-group">
                                    <label class="custom-file">
                                        <input type="file" id="profile_pic_url" name="profile_pic_url" class="custom-file-input" accept=".png, .jpg, .jpeg, .bmp"> 
                                        <span class="custom-file-control" data-label="Upload Profile Picture"></span>
                                    </label>
                                </div>
                                <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize">Save Changes</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection