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
                            <li class="breadcrumb-item active" aria-current="page">User</li>
                        </ol>
                    </nav>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.user.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add New User</a></div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" class="search-company">
                                <div class="form-group">
                                    <div class="d-flex"><input type="text" class="form-control" placeholder="link here"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find User</button></div>
                                </div>
                            </form>
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">City <i class="fa fa-caret-down" aria-hidden="true"></i></th>
                                        <th colspan="2" scope="col" width="30%">Company</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td scope="row"><a href="{{route('admin.user.edit', $user->username)}}">{{$user->name}}</a></td>
                                        <td>{{$user->user_city}}</td>
                                        <td>{{$user->company ? $user->company->company_name : '-'}}</td>
                                        <td><a href="{{route('admin.user.edit', $user->username)}}" class="px-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$users->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
