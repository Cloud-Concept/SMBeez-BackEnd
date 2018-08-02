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
                            <li class="breadcrumb-item active" aria-current="page">Claims</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" class="search-company">
                                <div class="form-group">
                                    <div class="d-flex"><input type="text" class="form-control" placeholder="link here"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Company</button></div>
                                </div>
                            </form>

                            <h4>Claim company request</h4>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($claims as $claim)
                                    <tr>
                                        <td scope="row">{{$claim->company->company_name}}</td>
                                        <td>{{$claim->user->first_name . " " . $claim->user->last_name}}</td>
                                        <td>
                                            {{$claim->role}}
                                        </td>
                                        <td>
                                            <div class="d-flex"><a href="{{route('admin.show_claim', $claim->id)}}" class="px-2"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
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