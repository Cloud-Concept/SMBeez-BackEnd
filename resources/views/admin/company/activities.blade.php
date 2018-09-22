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
                            <li class="breadcrumb-item active" aria-current="page">Acivities</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Company "{{$company->company_name}}" Activities</h4>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Log Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">By</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $activity)
                                    <tr>
                                        <td>{{$activity->log_name}}</td>
                                        <td>{{$activity->description}}</td>
                                        <td>{{$activity->causer['first_name']}}</td>
                                        <td>{{$activity->properties}}</td>
                                        <td>{{$activity->created_at->toDateTimeString()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection