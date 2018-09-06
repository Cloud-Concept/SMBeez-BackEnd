@extends('layouts.inner')

@section('content')

<main class="cd-main-content">
    <section class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{route('home')}}" class="btn btn-dark btn-dash btn-yellow">الرجوع الي الرئيسية</a>
                    <div class="error-img"><img src="{{asset('images/common/error-404.png')}}" alt="error 404" class="img-fluid"></div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection