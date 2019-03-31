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
                            <li class="breadcrumb-item active" aria-current="page">Returning Users Reports</li>
                        </ol>
                    </nav>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Overall Returning Users Reports</h3>
                    <br>
                    <div class="row equal overview-blocks">
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$allreturning_loggedIn}}</p>
                                <p><a href="#">LoggedIn Returning User</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$allreturning_noLogin}}</p>
                                <p><a href="#">Anonymous Returning User</a></p>
                            </div>
                        </div>
                    </div>

                    <form action="{{route('admin.returning-users')}}" method="get">
                        <div class="form-group">
                            <div class="d-flex"><label>Date From: <input type="date" class="form-control" name="date_from" value="{{request()->query('date_from')}}"></label></div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex"><label>Date To: <input type="date" class="form-control" name="date_to" value="{{request()->query('date_to')}}"></label></div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-blue btn-yellow text-capitalize ml-3">
                        </div>
                    </form>
                    @if(request()->query('date_from') || request()->query('date_to'))
                    <h3>From "{{request()->query('date_from')}}" To "{{request()->query('date_to')}}"</h3>
                    <br>
                    <div class="row equal overview-blocks">
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$returning_loggedIn}}</p>
                                <p><a href="#">LoggedIn Returning User</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$returning_noLogin}}</p>
                                <p><a href="#">Anonymous Returning User</a></p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
