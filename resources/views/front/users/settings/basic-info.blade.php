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
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">{{__('general.my_dashboard')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('general.edit_settings')}}</li>
                        </ol>
                    </nav>
                    <!-- <div class="alert alert-secondary alert-dismissible fade show my-4" role="alert">
                        <h3>You are subscribed to our free plan <a href="" class="pull-right text-capitalize disable">upgrade</a></h3>
                        <p>Upgrade your plan before 26/9/2018 and enjoy lots of amazing features</p>
                    </div> -->
                    <div class="row">
                        <div class="col-md-7">
                            <form action="{{route('front.user.update_basic', $user->username)}}" method="POST" class="user-setting" role="form" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="">{{__('general.first_name')}}</label>
                                    <div class="d-flex"><input type="text" name="first_name" class="form-control" placeholder="{{__('general.first_name')}}" value="{{$user->first_name}}" required></div>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('general.last_name')}}</label>
                                    <div class="d-flex"><input type="text" name="last_name" class="form-control" placeholder="{{__('general.last_name')}}" value="{{$user->last_name}}" required></div>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('general.email')}}</label>
                                    <div class="d-flex"><input type="text" name="email" class="form-control" placeholder="{{__('general.email')}}" value="{{$user->email}}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('general.password')}}</label>
                                    <div class="d-flex"><input type="password" name="password" class="form-control" placeholder="{{__('general.password')}}"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('general.phone')}}</label>
                                    <div class="d-flex"><input type="text" name="phone" class="form-control" placeholder="{{__('general.phone')}}" value="{{$user->phone}}"></div>
                                </div>
                                <div class="form-group">
                                    <label>{{__('general.profile_pic')}}</label>
                                    <br>
                                    <label class="custom-file">
                                        <input type="file" id="profile_pic_url" name="profile_pic_url" class="custom-file-input" accept=".png, .jpg, .jpeg, .bmp"> 
                                        <span class="custom-file-control" data-label="Upload Profile Picture"></span>
                                    </label>
                                </div>
                                <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize">{{__('general.save_changes')}}</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@if($hascompany)
    @include ('layouts.create-project-modal')
@else
    @include ('layouts.add-company-modal')
@endif

@endsection