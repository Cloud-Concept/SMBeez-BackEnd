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
                            <li class="breadcrumb-item active" aria-current="page">Indusrties</li>
                        </ol>
                    </nav>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.industry.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add a new Indusrty</a></div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover my-4">
                                <tbody>
                                    @foreach($industries as $industry)
                                    <tr>
                                        <td scope="row">{{$industry->industry_name}}</td>
                                        <td width="10%">
                                            <div class="d-flex"><a href="{{route('admin.industry.edit', $industry->slug)}}" class="px-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{$industries->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection