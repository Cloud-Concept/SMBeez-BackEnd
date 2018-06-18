@extends('layouts.admin')

@section('content')

<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.moderator-sidebar')
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Activity Type</th>
                                        <th scope="col">Activity Log</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_logs as $log)
                                    <tr class="company-row">
                                        <td scope="row">{{$log->company->company_name}}</td>
                                        <td scope="row">{{$log->activity_type}}</td>
                                        <td scope="row">{{$log->activity_log}}</td>
                                        @if($log->activity_type == 'report_create' || $log->activity_type == 'report_update')
                                        <td class="report-status">{{$log->company->mod_report->status}}</td>
                                        @else
                                        <td class="report-status">-</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="company-row table-success">
                                        <td scope="row">Sums</td>
                                        <td scope="row">{{$logs['overall_successful_calls']}} Successful Calls</td>
                                        <td scope="row">{{$logs['overall_unsuccessful_calls']}} Unuccessful Calls</td>
                                        <td scope="row">{{$logs['overall_inqueue']}} InQueue</td>
                                    </tr>
                                </tfoot>
                            </table>
                            {{$all_logs->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include ('layouts.moderator-dashboard-js')

@endsection