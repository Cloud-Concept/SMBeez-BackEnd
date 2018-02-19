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
                            <li class="breadcrumb-item active" aria-current="page">Edit Industry "{{$industry->industry_name}}"</li>
                        </ol>
                    </nav>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form class="user-setting" action="{{route('admin.industry.update', $industry->slug)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <p class="form-group">
                            <label for="">Industry Name</label>
                            <input class="form-control" type="text" value="{{$industry->industry_name}}" name="industry_name" placeholder="Industry Name" id="industry_name">
                        </p>
                        <p class="form-group">
                            <label for="">Industry Image</label>
                            <br>
                            <label class="custom-file">
                                <input type="file" id="industry_img_url" name="industry_img_url" class="custom-file-input" accept=".jpg, .png, .jpeg"> 
                                <span class="custom-file-control" data-label="Industry Image"></span>
                            </label>
                        </p>
                        <br>
                        @if($industry->industry_img_url)
                        <div class="media">
                            <img src="{{asset($industry->industry_img_url)}}" alt="">
                        </div>
                        @endif
                        <br>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
