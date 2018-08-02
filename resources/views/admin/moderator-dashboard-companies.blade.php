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
                            <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.company.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add a new Company</a></div>
                            <form class="user-setting sd-tickets" action="{{route('mod.filter.companies')}}" role="search" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="city" class="form-control custom-select d-block">
                                                <option value="Cairo">Cairo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="industry" class="form-control custom-select d-block">
                                                <option value="">{{__('general.all_industries_title')}}</option>
                                                @foreach($industries as $key => $getindustry)
                                                    @if(app()->getLocale() == 'ar')
                                                    <option value="{{$getindustry->id}}" {{ $getindustry->id == request()->query('industry') ? 'selected' : ''}}>{{$getindustry->industry_name_ar}}</option>
                                                    @else
                                                    <option value="{{$getindustry->id}}" {{ $getindustry->id == request()->query('industry') ? 'selected' : ''}}>{{$getindustry->industry_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex">
                                        <select name="status" class="form-control custom-select d-block">
                                           @foreach($status_array as $status)
                                                <option value="{{$status}}" {{ $status == request()->query('status') ? 'selected' : ''}}>{{$status}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex"><input class="form-control" name="s" value="{{request()->query('s')}}" placeholder="Search Company" type="search"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Company</button></div>
                                </div>
                            </form>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Status <i class="fa fa-caret-down" aria-hidden="true"></i></th>
                                        <th scope="col">Industry</th>
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
                                        @if(app()->getLocale() == 'ar')
                                        <td>{{$company->industry->industry_name_ar}}</td>
                                        @else
                                        <td>{{$company->industry->industry_name}}</td>
                                        @endif
                                        <td>
                                            <div class="d-flex company-info">
                                                <input type="hidden" class="get-info" company-id="{{$company->slug}}" company-name="{{$company->company_name}}" />
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#edit-company" class="px-2 edit-company"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#report-company" class="px-2 report-company" alt="Report Company"><i class="fa fa-list" aria-hidden="true"></i></a>
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#email-company" class="px-2 email-company"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                                <!-- <a href="#" id="hide-company-{{$company->slug}}" class="px-2" company-id="{{$company->slug}}" onClick="event.preventDefault(); if(confirm('Do you really need to hide this company?')){ var e = $(this); hide_company(e)}"><i class="fa fa-eye-slash" aria-hidden="true"></i></a> -->
                                                <a href="{{route('front.company.show', $company->slug)}}" target="_blank" class="px-2"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a href="{{route('admin.company.edit', $company->slug)}}" target="_blank" class="px-2"><i class="fa fa-clone" aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <script>

                                    /*function hide_company(e) {                                        
                                        var company_id = e.attr('company-id');
                                        console.log(company_id);
                                        var url = '{{ route("hide-company-ajax", ":company_id") }}';
                                        $.post(url.replace(':company_id', company_id),
                                        {
                                            status : 0,
                                            mod_user: '{{Auth()->user()->id}}',

                                            $('.'+ company_id).hide();
                                        });

                                    }*/
                                    </script>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$companies->appends(['city' => request()->input('city'), 'industry' => request()->input('industry'), 'status' => request()->input('status'), 's' => request()->input('s') ])->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include ('layouts.moderator-dashboard-js')

@endsection