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
                            <li class="breadcrumb-item active" aria-current="page">User Logins</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('admin.user.logins')}}" method="get">
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
                            <h1>Logins From {{request()->query('date_from')}} TO {{request()->query('date_to')}}</h1>
                            @else
                            <h1>Overall Logins</h1>
                            @endif
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">User Email</th>
                                        <th scope="col">Total Logins</th>
                                        <th scope="col">Company</th>
                                        @if(request()->query('date_from') || request()->query('date_to'))
                                        <th scope="col">Time</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                    <tr>
                                        <td><a href="{{route('admin.user.edit', $list['user']->username)}}">{{$list['user']->email}}</a></td>
                                        <td><a href="{{route('admin.user.user-logins', $list['user']->username)}}">{{$list['logins']}}</a></td>
                                        <td>{{$list['user']->company ? $list['user']->company->company_name : '-'}}</td>
                                        @if(request()->query('date_from') || request()->query('date_to'))
                                        <td>{{request()->query('date_from')}} - {{request()->query('date_to')}}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$lists->appends(['date_from' => request()->input('date_from'), 'date_to' => request()->input('date_to')])->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
