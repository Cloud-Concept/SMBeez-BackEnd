@extends('layouts.admin')

@section('content')
<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @role('superadmin')
                        @include('layouts.superadmin-sidebar')
                    @endrole
                    @role('moderator')
                        @include('layouts.moderator-sidebar')
                    @endrole
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Logins</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">User Email</th>
                                        <th scope="col">Logins</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logins as $login)
                                    <tr>
                                        <td><a href="@role('superadmin'){{route('admin.user.edit', $login->user->username)}}@endrole">{{$login->user->email}}</a></td>
                                        <td>1</td>
                                        <td>{{$login->user->company ? $login->user->company->company_name : '-'}}</td>
                                        <td>{{$login->created_at->toDateTimeString()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$logins->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
