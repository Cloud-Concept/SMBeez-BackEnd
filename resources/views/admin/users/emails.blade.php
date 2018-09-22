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
                            <li class="breadcrumb-item active" aria-current="page">User Emails</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('admin.user.emails')}}" method="get">
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
                            <h1>Emails From {{request()->query('date_from')}} TO {{request()->query('date_to')}}</h1>
                            @else
                            <h1>Overall Emails</h1>
                            @endif
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">User Email</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emails as $email)
                                    <tr>
                                        <td><a href="{{$email->user_id != 0 ? route('admin.user.edit', $email->user->username) : '#'}}">{{$email->user_id != 0 ? $email->user->email : 'Anonymous'}}</a></td>
                                        <td>{{$email->user_id != 0 && $email->user->company ? $email->user->company->company_name : '-'}}</td>
                                        <td>{{$email->created_at->toDateTimeString()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$emails->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
