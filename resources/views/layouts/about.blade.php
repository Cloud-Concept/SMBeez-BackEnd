@extends('layouts.inner')

@section('content')

<main class="cd-main-content">
    <section class="hero about-hero">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Matchmaking for Small Businesses</h1>
                    <p class="text-center">Find work and source suppliers in your local marketplace...</p>
                </div>
            </div>
        </div>
    </section>
    <section class="about-intro">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mrt-auto">
                    <h2 class="text-center pt-5 pb-4">What is Masharee3?</h2>
                    <p>CD screens are uniquely modern in style, and the liquid crystals that make them work have allowed humanity to create slimmer, more portable technology than we’ve ever had access to before. From your wrist watch to your laptop, a lot of the on the go electronics that we tote from place to place are only possible because of their thin, light LCD display screens. Liquid crystal display (LCD) technology still has some stumbling blocks in its path that can make it unreliable at times, but on the whole the invention of the LCD screen has allowed great leaps forward in global technological progress.</p>
                    <p class="pt-4">Although liquid crystals are not really liquid, their molecules behave more like a liquid than they do like a solid, which earns them their name. The crystals in an LCD exist in a kind of a unique middle ground between solid form and liquid form, which gives them the movement and flexibility of a liquid; but can also let them remain in place, like a solid. Heat can quickly melt a solid to liquid, allowing it to move, whereas cool will make the liquid solidify almost instantly.</p>
                    @if (Auth::guest())
                    	<div class="text-center py-4 mb-5"><a href="{{ route('login') }}" class="btn btn-blue btn-yellow">Sign Up Today</a></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- <section class="video-demo d-flex justify-content-center align-items-center"><a href="#" class="btn btn-play"><i class="fa fa-play-circle-o fa-2x" aria-hidden="true"></i><br>Watch the Demo</a></section> -->
    <section class="find-be-block py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 text-center">
                    <h3>Find Work</h3>
                    <p class="w-75 mt-3 mrt-auto">Browse hundreds of projects and express interest in the projects that suit you. Apply through Masharee3 or contact the clients directly. Check out the clients’ reviews by other suppliers like you and engage confidently in business relationships based on mutual trust.</p>
                </div>
                <div class="col-md-6 text-center">
                    <h3>Be Found</h3>
                    <p class="w-75 mt-3 mrt-auto">Browse hundreds of projects and express interest in the projects that suit you. Apply through Masharee3 or contact the clients directly. Check out the clients’ reviews by other suppliers like you and engage confidently in business relationships based on mutual trust.</p>
                </div>
                <div class="col-md-12 text-center py-5">
                	@if (!Auth::guest() && $hascompany)
                    <a href="{{route('front.company.all')}}" class="btn btn-blue btn-yellow"><i class="fa fa-clone" aria-hidden="true"></i> Browse Companies</a>
                    @elseif(!Auth::guest() && count(Auth::user()->claims) > 0)
                    <a href="{{route('front.company.all')}}" class="btn btn-blue btn-yellow"><i class="fa fa-clone" aria-hidden="true"></i> Browse Companies</a>
                    @elseif (!Auth::guest() && !$hascompany)
                    <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue btn-yellow"><i class="fa fa-clone" aria-hidden="true"></i> Add your company</a>
                    @elseif (!Auth::guest() && !count(Auth::user()->claims) > 0)
                    <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue btn-yellow"><i class="fa fa-clone" aria-hidden="true"></i> Add your company</a>
                    @elseif(Auth::guest())
                    <a href="{{route('login')}}?action=add-company" class="btn btn-blue btn-yellow"><i class="fa fa-clone" aria-hidden="true"></i> Add your company</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="terms-block bg-blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 py-5">
                    <div class="pl-5">
                        <h3>Terms & Conditions</h3>
                        <p class="mt-5 mb-5">There is a lot of exciting stuff going on in the stars above us that make astronomy so much fun. The truth is the universe is a constantly changing, moving, some would say “living” thing because you just never know what you are going to see on any given night of stargazing.</p>
                        <a href="" class="btn btn-blue btn-yellow-2">Read the document</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


@if (!Auth::guest() && !$hascompany)
    @include ('layouts.add-company-modal')
@endif


@endsection