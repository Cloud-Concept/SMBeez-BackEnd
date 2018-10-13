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
                            <li class="breadcrumb-item active" aria-current="page">Companies</li>
                        </ol>
                    </nav>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.company.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add a new Company</a></div>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('moderator.companies.dashboard')}}" class="btn btn-alert text-capitalize"><i class="fa fa-eye fa-3x" aria-hidden="true"></i> View As Moderator</a></div>
                    <div class="row">
                        <div class="col-md-12">
                            <form class="user-setting sd-tickets" action="{{route('superadmin.filter.companies')}}" role="search" method="get">
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
                                    <div class="d-flex"><input class="form-control" name="s" value="{{request()->query('s')}}" placeholder="Search Company" type="search"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Company</button></div>
                                </div>
                            </form>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Industry <i class="fa fa-caret-down" aria-hidden="true"></i></th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $company)
                                    <tr>
                                        <td scope="row">{{$company->company_name}}</td>
                                        @if(app()->getLocale() == 'ar')
                                        <td>{{$company->industry->industry_name_ar}}</td>
                                        @else
                                        <td>{{$company->industry->industry_name}}</td>
                                        @endif
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{route('admin.company.edit', $company->slug)}}" class="px-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="{{route('admin.company.edit', $company->slug)}}" class="px-2 {{$company->is_promoted == 1 ? 'active' : 'disable'}}" alt="Featured"><i class="fa fa-bullhorn" aria-hidden="true"></i></a>
                                                <a href="{{route('front.company.show', $company->slug)}}" class="px-2"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{$companies->appends(['city' => request()->input('city'), 'industry' => request()->input('industry'), 's' => request()->input('s') ])->links()}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection