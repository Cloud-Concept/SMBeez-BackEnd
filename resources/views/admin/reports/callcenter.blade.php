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
                            <li class="breadcrumb-item active" aria-current="page">Call Center Reports</li>
                        </ol>
                    </nav>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Today's Call Center Reports</h3>
                    <br>
                    <div class="row equal overview-blocks">
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_company_updates']}}</p>
                                <p><a href="#">Company Updates</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_report_creates']}}</p>
                                <p><a href="#">Reports Created</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_assign_users']}}</p>
                                <p><a href="#">Assigned Existing User To Company</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_assign_new_user']}}</p>
                                <p><a href="#">Created new User To Company</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_message_sent']}}</p>
                                <p><a href="#">Messages Sent To Users</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_companies_by_users']}}</p>
                                <p><a href="#">Companies Created By Users</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_companies_imported_admin']}}</p>
                                <p><a href="#">Companies Imported By Admin</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_successful_calls']}}</p>
                                <p><a href="#">Successful Calls</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['today_unsuccessful_calls']}}</p>
                                <p><a href="#">Unsuccessful Calls</a></p>
                            </div>
                        </div>
                    </div>

                    <h3>Overall Call Center Reports</h3>
                    <br>
                    <div class="row equal overview-blocks">
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_company_updates']}}</p>
                                <p><a href="#">Company Updates</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_report_creates']}}</p>
                                <p><a href="#">Reports Created</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_assign_users']}}</p>
                                <p><a href="#">Assigned Existing User To Company</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_assign_new_user']}}</p>
                                <p><a href="#">Created new User To Company</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_message_sent']}}</p>
                                <p><a href="#">Messages Sent To Users</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_companies_by_users']}}</p>
                                <p><a href="#">Companies Created By Users</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_companies_imported_admin']}}</p>
                                <p><a href="#">Companies Imported By Admin</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_successful_calls']}}</p>
                                <p><a href="#">Successful Calls</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_unsuccessful_calls']}}</p>
                                <p><a href="#">Unsuccessful Calls</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['overall_inqueue']}}</p>
                                <p><a href="#">InQueue</a></p>
                            </div>
                        </div>
                    </div>

                    <form action="{{route('callcenter.reports')}}" method="get">
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
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_company_updates']}}</p>
                                <p><a href="#">Company Updates</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_report_creates']}}</p>
                                <p><a href="#">Reports Created</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_assign_users']}}</p>
                                <p><a href="#">Assigned Existing User To Company</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_assign_new_user']}}</p>
                                <p><a href="#">Created new User To Company</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_message_sent']}}</p>
                                <p><a href="#">Messages Sent To Users</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_companies_by_users']}}</p>
                                <p><a href="#">Companies Created By Users</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_companies_imported_admin']}}</p>
                                <p><a href="#">Companies Imported By Admin</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_successful_calls']}}</p>
                                <p><a href="#">Successful Calls</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1">{{$logs['range_unsuccessful_calls']}}</p>
                                <p><a href="#">Unsuccessful Calls</a></p>
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
