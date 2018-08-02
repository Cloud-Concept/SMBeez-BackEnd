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
                    @if($industry->is_disabled == 0)
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); if(confirm('Do you want to disable this Industry?')){document.getElementById('disable').submit();}"><i class="fa fa-trash fa-3x" aria-hidden="true"></i> Disable Industry</a></div>
                    <form id="disable" action="{{route('admin.industry.disable', $industry->slug)}}" method="post">
                        {{csrf_field()}}                        
                    </form>
                    @else
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); if(confirm('Do you want to enable this Industry?')){document.getElementById('enable').submit();}"><i class="fa fa-trash fa-3x" aria-hidden="true"></i> Enable Industry</a></div>
                    <form id="enable" action="{{route('admin.industry.enable', $industry->slug)}}" method="post">
                        {{csrf_field()}}                        
                    </form>
                    @endif
                    <form class="user-setting" action="{{route('admin.industry.update', $industry->slug)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <p class="form-group">
                            <label for="">Industry Name</label>
                            <input class="form-control" type="text" value="{{$industry->industry_name}}" name="industry_name" placeholder="Industry Name" id="industry_name">
                        </p>
                        <p class="form-group">
                            <label for="">Industry Arabic Name</label>
                            <input class="form-control" type="text" value="{{$industry->industry_name_ar}}" name="industry_name_ar" placeholder="Industry Arabic Name" id="industry_name_ar">
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
                        <p class="form-group">
                            <label for="">Industry Arabic Image</label>
                            <br>
                            <label class="custom-file">
                                <input type="file" id="industry_img_url_ar" name="industry_img_url_ar" class="custom-file-input" accept=".jpg, .png, .jpeg"> 
                                <span class="custom-file-control" data-label="Industry Arabic Image"></span>
                            </label>
                        </p>
                        <br>
                        <p class="form-group">
                            <label for="">Display In</label>
                            <select name="display" class="form-control custom-select d-block">
                                <option value="">Choose Display</option>
                                @foreach($display as $key => $value)
                                <option value="{{$key}}" {{$industry->display == $key ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </p>
                        <br>
                        @if(file_exists(public_path($industry->industry_img_url)))
                        <div class="media clearfix">
                            <img width="100%" src="{{asset($industry->industry_img_url)}}" alt="">
                        </div>
                        @endif
                        <br>
                        @if(file_exists(public_path($industry->industry_img_url_ar)))
                        <div class="media clearfix">
                            <img width="100%" src="{{asset($industry->industry_img_url_ar)}}" alt="">
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
