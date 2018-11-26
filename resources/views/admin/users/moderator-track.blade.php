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
                            <li class="breadcrumb-item active" aria-current="page">Track Portfolio</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-12">
                            <form  method="get">
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
                            <h1>Tracking From {{request()->query('date_from')}} TO {{request()->query('date_to')}}</h1>
                            @else
                            <h1>Overall Trackings</h1>
                            @endif
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Login</th>
                                        <th scope="col">Projects</th>
                                        <th scope="col">Interests</th>
                                        <th scope="col">Accept Interests</th>
                                        <th scope="col">Decline Interests</th>
                                        <th scope="col">Customer Reviews</th>
                                        <th scope="col">Supplier Reviews</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $csm)
                                    <tr>
                                        <td>{{$csm['company']->company_name}}</td>
                                        <td>Yes</td>
                                        <td>{{$csm['projects_count']}}</td>
                                        <td>{{$csm['express_interest']}}</td>
                                        <td>{{$csm['accept_interest']}}</td>
                                        <td>{{$csm['decline_interest']}}</td>
                                        <td>{{$csm['customer_reviews']}}</td>
                                        <td>{{$csm['supplier_reviews']}}</td>
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
