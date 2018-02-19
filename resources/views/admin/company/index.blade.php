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
                            <li class="breadcrumb-item"><a href="#">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Companies</li>
                        </ol>
                    </nav>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.company.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add a new Company</a></div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" class="search-company">
                                <div class="form-group">
                                    <div class="d-flex"><input type="text" class="form-control" placeholder="link here"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Company</button></div>
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
                                        <td>{{$company->industry->industry_name}}</td>
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

                            {{$companies->links()}}

                            <h4>Claimed company request</h4>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($claims as $claim)
                                    <tr>
                                        <td scope="row">{{$claim->company->company_name}}</td>
                                        <td>{{$claim->user->name}}</td>
                                        <td>
                                            <div class="d-flex"><a href="" class="px-2"><i class="fa fa-eye" aria-hidden="true"></i></a> <a href="" class="px-2"><i class="fa fa-check" aria-hidden="true"></i></a> <a href="" class="px-2"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{$claims->links()}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection