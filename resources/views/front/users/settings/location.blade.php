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
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                    <!-- <div class="alert alert-secondary alert-dismissible fade show my-4" role="alert">
                        <h3>You are subscribed to our free plan <a href="" class="pull-right text-capitalize disable">upgrade</a></h3>
                        <p>Upgrade your plan before 26/9/2018 and enjoy lots of amazing features</p>
                    </div> -->
                    <div class="row">
                        <div class="col-md-7">
                            <form action="{{route('front.user.update_location', $user->username)}}" method="POST"  class="user-setting" role="form" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="">Choose New City</label>
                                    <select class="form-control custom-select d-block" name="user_city" required>
                                        <option value="Dubai">Dubai</option>
                                    </select>
                                </div>
                                <p class="form-guide">“SMBeez is now covering Dubai city only, we will be adding more cities very soon. Stay Tuned!”</p>
                                <br>
                                <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize">Save Changes</button></div>
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