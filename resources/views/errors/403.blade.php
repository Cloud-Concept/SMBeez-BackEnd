@extends('layouts.inner')

@section('content')

<main class="cd-main-content">
    <section class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{route('home')}}" class="btn btn-dark btn-dash btn-yellow">Back to Website</a>
                    <div class="error-img"><img src="{{asset('images/common/error-403.png')}}" alt="error 403" style="max-width:500px;" class="img-fluid"></div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection