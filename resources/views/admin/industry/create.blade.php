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
                            <li class="breadcrumb-item active" aria-current="page">Create Industry</li>
                        </ol>
                    </nav>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form class="user-setting" action="{{route('admin.industry.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <p class="form-group">
                            <label for="">Industry Name</label>
                            <input class="form-control" type="text" name="industry_name" placeholder="Industry Name" id="industry_name">
                        </p>
                        <p class="form-group">
                            <label for="">Industry Arabic Name</label>
                            <input class="form-control" type="text" name="industry_name_ar" placeholder="Industry Arabic Name" id="industry_name_ar">
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
                                <option value="both">Companies & Projects</option>
                                <option value="companies">Companies Only</option>
                                <option value="projects">Projects Only</option>
                            </select>
                        </p>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
