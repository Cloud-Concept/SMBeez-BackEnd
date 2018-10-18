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
                            <li class="breadcrumb-item active" aria-current="page">Hidden Companies</li>
                        </ol>
                    </nav>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.company.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add a new Company</a></div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <form action="" class="search-company">
                                <div class="form-group">
                                    <div class="d-flex"><input type="text" class="form-control" placeholder="link here"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Company</button></div>
                                </div>
                            </form> -->
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
                                    <tr class="{{$company->slug}}">
                                        <td scope="row"><a href="{{route('front.company.show', $company->slug)}}" title="{{$company->company_name}}">{{$company->company_name}}</a></td>
                                        @if(app()->getLocale() == 'ar')
                                        <td>{{$company->industry->industry_name_ar}}</td>
                                        @else
                                        <td>{{$company->industry->industry_name}}</td>
                                        @endif
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{route('admin.company.edit', $company->slug)}}" class="px-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="{{route('admin.company.edit', $company->slug)}}" class="px-2 {{$company->is_promoted == 1 ? 'active' : 'disable'}}" alt="Featured"><i class="fa fa-bullhorn" aria-hidden="true"></i></a>
                                                <a href="#" id="unhide-company-{{$company->slug}}" company-id="{{$company->slug}}" title="Un Hide Company" class="px-2" onClick="event.preventDefault(); if(confirm('Do you really need to unhide this company?')){ var e = $(this); unhide_company(e)}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <script>
                                    function unhide_company(e) {                                        
                                        var company_id = e.attr('company-id');
                                        console.log(company_id);
                                        var url = '{{ route("unhide-company-ajax", ":company_id") }}';
                                        $.post(url.replace(':company_id', company_id),
                                        {
                                            status : 1,
                                            mod_user: '{{Auth()->user()->id}}',
                                        }).done(function( data ) {
                                            $('.'+ company_id).hide();
                                        });

                                    }

                                    </script>
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

@endsection