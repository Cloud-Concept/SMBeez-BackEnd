@extends('layouts.inner')
<!-- This file has been removed from the design .. will be deleted on approval -->
@section('content')
<main class="cd-main-content">
    <section class="hero-company hero-all">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Discover hundreds of opportunities</h1>
                    <p class="text-center">In your local marketplace</p>
                </div>
            </div>
        </div>
    </section>
    <section class="all-projects">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @foreach($industries_1 as $industry)
                    <div class="all-box">
                        <h2 class="d-flex justify-content-between align-items-center p-2">{{$industry->industry_name}}<i class="fa fa-2x fa-angle-right" aria-hidden="true"></i></h2>
                        <a href="{{route('front.industry.show', $industry->slug)}}" title=""><img src="{{asset($industry->industry_img_url)}}" alt="" class="img-fluid img-full"></a>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    @foreach($industries_2 as $industry)
                    <div class="all-box">
                        <h2 class="d-flex justify-content-between align-items-center p-2">{{$industry->industry_name}}<i class="fa fa-2x fa-angle-right" aria-hidden="true"></i></h2>
                        <a href="{{route('front.industry.show', $industry->slug)}}" title=""><img src="{{asset($industry->industry_img_url)}}" alt="" class="img-fluid img-full"></a>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-3">
                    @foreach($industries_3 as $industry)
                    <div class="all-box">
                        <h2 class="d-flex justify-content-between align-items-center p-2">{{$industry->industry_name}}<i class="fa fa-2x fa-angle-right" aria-hidden="true"></i></h2>
                        <a href="{{route('front.industry.show', $industry->slug)}}" title=""><img src="{{asset($industry->industry_img_url)}}" alt="" class="img-fluid img-full"></a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                @foreach($industries_4 as $industry)
                <div class="col-md-4">
                    <div class="all-box">
                        <h2 class="d-flex justify-content-between align-items-center p-2">{{$industry->industry_name}}<i class="fa fa-2x fa-angle-right" aria-hidden="true"></i></h2>
                        <a href="{{route('front.industry.show', $industry->slug)}}" title=""><img src="{{asset($industry->industry_img_url)}}" alt="" class="img-fluid img-full"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="create-intro bg-blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-12 offset-md-3 text-center">
                    <h2>Be Found</h2>
                    <p class="mt-5 mb-5">Create your company profile and sar thousands of reliable suppliers in different industries. Contact suppliers through SMBeez or directly. Check out the suppliers’ reviews by other clients like you and engage confidently in business relationships based on mutual trust.</p>
                    <a href="" class="btn btn-blue btn-yellow-2">Browse Projects</a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection