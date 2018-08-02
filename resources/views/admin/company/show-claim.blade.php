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
                            <li class="breadcrumb-item active" aria-current="page">Claim request for {{$claim->company->company_name}}</li>
                        </ol>
                    </nav>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">

                            <h4>Claim request for company "{{$claim->company->company_name}}"</h4>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Role</th>
                                        @if(!$claim->status)
                                        <th scope="col" width="10%">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row">{{$claim->company->company_name}}</td>
                                        <td>{{$claim->user->first_name . " " . $claim->user->last_name}}</td>
                                        <td>
                                            {{$claim->role}}
                                        </td>
                                        @if(!$claim->status)
                                        <td>
                                            <div class="d-flex"><a href="#" onclick="event.preventDefault(); if(confirm('Do you want to accept the claim request?')){document.getElementById('accept').submit();}" class="px-2"><i class="fa fa-check" aria-hidden="true"></i></a> <a href="#" onclick="event.preventDefault(); if(confirm('Do you want to decline the claim request?')){document.getElementById('decline').submit();}" class="px-2"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                                        </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                            <form id="accept" action="{{route('admin.accept_claim', [$claim->id, $claim->company->slug])}}" method="post">
                                {{csrf_field()}} 
                            </form>
                            <form id="decline" action="{{route('admin.decline_claim', [$claim->id, $claim->company->slug])}}" method="post">
                                {{csrf_field()}} 
                            </form>
                            <br>
                            <div class="alert alert-info">
                                Comment:
                                <br>
                                {{strip_tags($claim->comments)}}
                            </div>
                            <br>
                            <div class="download-box d-flex justify-content-between align-items-center">
                            
                                @if($claim->document)
                                    <div>
                                        @if(file_exists(public_path('/companies/files/'. $claim->document)))
                                            <p class="list-item more-inf"><a href="{{asset('companies/files/'. $claim->document)}}" target="_blank"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Download File"></i> {{$claim->document}}</a></p>
                                        @else
                                            <p class="list-item more-inf"></a><a href="{{asset('companies/files/'. $claim->document)}}" target="_blank"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Download File"></i> <strike>{{$claim->document}}</strike> <i>({{__('project.file_damaged')}})</i></a></p>  
                                        @endif
                                    </div>
                                @endif 
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection