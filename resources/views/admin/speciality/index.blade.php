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
                            <li class="breadcrumb-item active" aria-current="page">Specialites</li>
                        </ol>
                    </nav>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.speciality.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add a new Specialites</a></div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <h3 class="border-title mb-3 pb-2 text-capitalize">Newely Suggested</h3>
                            <ul class="list-tag">
                                <li><a href="" class="btn-outline-success"><i class="fa fa-check" aria-hidden="true"></i></a> <a href="" class="btn-outline-danger"><i class="fa fa-times" aria-hidden="true"></i></a> tag</li>
                                <li><a href="" class="btn-outline-success"><i class="fa fa-check" aria-hidden="true"></i></a> <a href="" class="btn-outline-danger"><i class="fa fa-times" aria-hidden="true"></i></a> tag</li>
                                <li><a href="" class="btn-outline-success"><i class="fa fa-check" aria-hidden="true"></i></a> <a href="" class="btn-outline-danger"><i class="fa fa-times" aria-hidden="true"></i></a> tag</li>
                            </ul> -->
                            <h3 class="border-title mb-3 mt-4 pb-2 text-capitalize">List of Specialities</h3>
                            <ul class="list-group-split">
                                @foreach($specialities as $speciality)
                                <li><a href="{{route('admin.speciality.edit', $speciality->slug)}}">{{$speciality->speciality_name}}</a></li>
                                @endforeach
                            </ul>

                            {{$specialities->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection