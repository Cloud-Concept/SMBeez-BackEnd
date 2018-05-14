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
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Overview</li>
                        </ol>
                    </nav>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row equal overview-blocks">
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$users}}</p>
                                <p><a href="{{route('admin.user.index')}}">Users</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$companies}}</p>
                                <p><a href="{{route('admin.companies')}}">Companies</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$customer_reviews}}</p>
                                <p><a href="">Review From Cusomters</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$supplier_reviews}}</p>
                                <p><a href="">Reviews from Suppliers</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$projects}}</p>
                                <p><a href="{{route('admin.projects')}}">Published Projects</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$completed_projects}}</p>
                                <p><a href="{{route('admin.projects')}}">Completed Projects</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$industries}}</p>
                                <p><a href="{{route('admin.industries')}}">Industries</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$specialities}}</p>
                                <p><a href="{{route('admin.specialities')}}">Specialities</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
