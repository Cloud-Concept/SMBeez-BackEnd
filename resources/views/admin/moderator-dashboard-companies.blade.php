@extends('layouts.admin')

@section('content')

<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @if(\Laratrust::hasRole('moderator'))
                        @include('layouts.moderator-sidebar')
                    @else
                        @include('layouts.superadmin-sidebar')
                    @endif
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
                                        @if(Request::is('admin/dashboard/moderator/mycompanies/*'))
                                            <input type="hidden" name="manager_id" value="{{Auth::user()->id}}"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex">
                                        <select name="status" class="form-control custom-select d-block">
                                            <option value="">All Status</option>
                                           @foreach($status_array as $status)
                                                <option value="{{$status}}" {{ $status == request()->query('status') ? 'selected' : ''}}>{{$status}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <select name="moderator" class="form-control custom-select d-block">
                                        <option value="">All Moderators</option>
                                        <option value="unassigned" {{request()->query('moderator') == 'unassigned' ? 'selected' : ''}}>Unassigned</option>
                                        @foreach($moderators as $moderator)
                                            <option value="{{$moderator->id}}" {{ $moderator->id == request()->query('moderator') ? 'selected' : ''}}>{{$moderator->first_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <select name="verified" class="form-control custom-select d-block">
                                        <option value="">Verified/UnVerified</option>
                                        @foreach($verified as $key => $verify)
                                            <option value="{{$verify}}" {{ $verify == request()->query('verified') ? 'selected' : ''}}>{{$key}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="promoted" class="form-control custom-select d-block">
                                        <option value="">Promoted/UnPromoted</option>
                                        @foreach($promoted as $key => $promote)
                                            <option value="{{$promote}}" {{ $promote == request()->query('promoted') ? 'selected' : ''}}>{{$key}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex"><input class="form-control" name="s" value="{{request()->query('s')}}" placeholder="Search Company" type="search"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Company</button></div>
                                </div>
                            </form>
                            <form action="" class="user-setting sd-tickets" method="get">
                                <div class="form-group">
                                    <div class="d-flex">
                                        <label for="">Page No.</label>
                                        <input type="number" class="form-control" name="page" value="{{request()->query('page') ? request()->query('page') : 1}}"/>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Status <i class="fa fa-caret-down" aria-hidden="true"></i></th>
                                        <th scope="col" width="10%">User</th>
                                        <th scope="col"></th>
                                        <th scope="col">Industry</th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $company)
                                    <tr class="company-row {{$company->slug}}">
                                        <td scope="row">{{$company->company_name}}</td>
                                        <td class="report-status {{$company->slug}}">{{$company->mod_status}}</td>
                                        <td class="user-manager" colspan="2">
                                        @if($company->manager($company->manager_id) && \Laratrust::hasRole('moderator'))
                                            {{$company->manager($company->manager_id)}}
                                        @elseif($company->manager($company->manager_id) && \Laratrust::hasRole('superadmin'))
                                            <form class="user-setting sd-tickets add-manager-{{$company->slug}}" id="choose-manager" method="post">
                                                <div class="form-group">
                                                <select name="manager" id="add-manager" company-id="{{$company->slug}}" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($moderators as $moderator)
                                                    <option value="{{$moderator->id}}" {{$moderator->id == $company->manager_id ? 'selected' : ''}}>{{$moderator->first_name}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </form>
                                        @else
                                            @if(\Laratrust::hasRole('moderator'))
                                            -
                                            @else
                                            <form class="user-setting sd-tickets add-manager-{{$company->slug}}" id="choose-manager" method="post">
                                                <div class="form-group">
                                                <select name="manager" id="add-manager" company-id="{{$company->slug}}" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($moderators as $moderator)
                                                    <option value="{{$moderator->id}}" {{$moderator->id == $company->manager_id ? 'selected' : ''}}>{{$moderator->first_name}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </form>
                                            @endif
                                        @endif
                                        </td>
                                        @if(app()->getLocale() == 'ar')
                                        <td>{{$company->industry->industry_name_ar}}</td>
                                        @else
                                        <td>{{$company->industry->industry_name}}</td>
                                        @endif
                                        <td>
                                            <div class="d-flex company-info">
                                                <input type="hidden" class="get-info" company-id="{{$company->slug}}" company-name="{{$company->company_name}}" />
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#edit-company" title="Quick Edit Company" class="px-2 edit-company"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#report-company" title="Report Company" class="px-2 report-company" title="Report Company"><i class="fa fa-list" aria-hidden="true"></i></a>
                                                <a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#email-company" title="Email Company" class="px-2 email-company"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                                <a href="#" id="hide-company-{{$company->slug}}" class="px-2" title="Hide Company" company-id="{{$company->slug}}" onClick="event.preventDefault(); if(confirm('Do you really need to hide this company?')){ var e = $(this); hide_company(e)}"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                <a href="{{route('front.company.show', $company->slug)}}" target="_blank" title="View Company" class="px-2"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a href="{{route('admin.company.edit', $company->slug)}}" target="_blank" title="Edit Company" class="px-2"><i class="fa fa-clone" aria-hidden="true"></i></a>
                                                @if(\Laratrust::hasRole('moderator') && !$company->manager_id)
                                                <a href="#" id="manage-company-{{$company->slug}}" class="px-2" title="Manage Company" company-id="{{$company->slug}}" onClick="event.preventDefault(); if(confirm('Do you really need to manage this company?')){ var e = $(this); manage_company(e)}"><i class="fa fa-hand-paper-o" aria-hidden="true"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <script>

                                    function hide_company(e) {                                        
                                        var company_id = e.attr('company-id');
                                        console.log(company_id);
                                        var url = '{{ route("hide-company-ajax", ":company_id") }}';
                                        $.post(url.replace(':company_id', company_id),
                                        {
                                            status : 0,
                                            mod_user: '{{Auth()->user()->id}}',
                                        }).done(function( data ) {
                                            $('.'+ company_id).hide();
                                        });

                                    }
                                    @if(\Laratrust::hasRole('moderator'))
                                    function manage_company(e) {                                        
                                        var company_id = e.attr('company-id');
                                        var url = '{{ route("manage-company-ajax", ":company_id") }}';
                                        $.post(url.replace(':company_id', company_id),
                                        {
                                            mod_user: '{{Auth()->user()->id}}',
                                        }).done(function( data ) {
                                            console.log(data)
                                            if(data.manager){
                                                $('.'+ company_id + ' .user-manager').text(data.manager);
                                                $('#manage-company-' + company_id).hide();
                                            }
                                            alert(data.msg);
                                        });

                                    }
                                    @endif
                                    $('.add-manager-{{$company->slug}} #add-manager').on('change', function() {
                                        var company_id = $(this).attr('company-id');
                                        var url = '{{ route("assign-company-to-manager-ajax", ":company_id") }}';
                                        var selected = $('.add-manager-{{$company->slug}} #add-manager option:selected').text();
                                        if(confirm('Do you really need to assign this company to ' + selected + '?')){
                                            $.post(url.replace(':company_id', company_id),
                                            {
                                                mod_user: this.value,
                                                assigner: '{{Auth::user()->id}}',
                                            }).done(function( data ) {
                                                console.log(data)
                                                alert(data.msg);
                                            });
                                        }
                                    });
                                    </script>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$companies->appends(['city' => request()->input('city'), 'industry' => request()->input('industry'), 'status' => request()->input('status'), 'verified' => request()->input('verified'), 'promoted' => request()->input('promoted'), 's' => request()->input('s') ])->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include ('layouts.moderator-dashboard-js')

@endsection