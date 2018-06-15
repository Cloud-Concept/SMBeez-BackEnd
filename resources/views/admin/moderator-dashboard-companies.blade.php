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
                            <form class="user-setting sd-tickets" action="{{route('mod.filter.companies')}}" role="search" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="city" class="form-control custom-select d-block">
                                                <option value="Dubai">Dubai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="industry" class="form-control custom-select d-block">
                                                <option value="">All Industries</option>
                                                @foreach($industries as $key => $getindustry)
                                                    <option value="{{$getindustry->id}}" {{ $getindustry->id == request()->query('industry') ? 'selected' : ''}}>{{$getindustry->industry_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <div class="d-flex">
                                        <select name="status" class="form-control custom-select d-block">
                                            <option value="In Queue">In Queue</option>
                                            <option value="Successful Call - Interested">Successful Call - Interested</option>
                                            <option value="Successful Call - Not Interested">Successful Call - Not Interested</option>
                                            <option value="Successful Call - Agreed to Call Back">Successful Call - Agreed to Call Back</option>
                                            <option value="Successful Call - Asked for more details via email">Successful Call - Asked for more details via email</option>
                                            <option value="Unsuccessful Call - Unreachable">Unsuccessful Call - Unreachable</option>
                                            <option value="Unsuccessful Call - Wrong number">Unsuccessful Call - Wrong number</option>
                                            <option value="Unsuccessful Call - No answer">Unsuccessful Call - No answer</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <div class="d-flex"><input class="form-control" name="s" value="{{request()->query('s')}}" placeholder="Search Company" type="search"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Company</button></div>
                                </div>
                            </form>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Status <i class="fa fa-caret-down" aria-hidden="true"></i></th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $company)
                                    <tr class="company-row {{$company->slug}}">
                                        <td scope="row">{{$company->company_name}}</td>
                                        @if($company->mod_report)
                                        <td class="report-status {{$company->slug}}">{{$company->mod_report->status}}</td>
                                        @else
                                        <td class="report-status {{$company->slug}}">In Queue</td>
                                        @endif
                                        <td>
                                            <div class="d-flex company-info">
                                                <input type="hidden" class="get-info" company-id="{{$company->slug}}" company-name="{{$company->company_name}}" />
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#edit-company" class="px-2 edit-company"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#report-company" class="px-2 report-company" alt="Report Company"><i class="fa fa-list" aria-hidden="true"></i></a>
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#email-company" class="px-2 email-company"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                                <a href="{{route('front.company.show', $company->slug)}}" target="_blank" class="px-2"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$companies->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include ('layouts.moderator-dashboard-js')

@endsection