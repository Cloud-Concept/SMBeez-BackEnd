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
                            <li class="breadcrumb-item active" aria-current="page">Moderators</li>
                        </ol>
                    </nav>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row equal overview-blocks">
                        @foreach($moderators as $moderator)
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$moderator->first_name}} {{$moderator->last_name}}</p>
                                <p><a href="{{route('admin.user.mod_stat', $moderator->username)}}">Check Statistics</a></p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection