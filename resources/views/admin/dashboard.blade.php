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
                    <div class="alert alert-secondary alert-dismissible fade show my-4 text-center" role="alert">
                        <h2>You have <b>(132)</b> pedding support tickets</h2>
                        <a href="" class="btn btn-blue btn-yellow text-capitalize mt-3">Resolve Tickets</a>
                    </div>
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
                                <p><a href="">Companies</a></p>
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
                                <p><a href="">Published Projects</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$completed_projects}}</p>
                                <p><a href="">Completed Projects</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$industries}}</p>
                                <p><a href="">Industries</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$specialities}}</p>
                                <p><a href="">Specialities</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
