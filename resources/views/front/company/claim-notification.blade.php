@extends('layouts.inner')

@section('content')
<main class="cd-main-content signup">
    <section class="sign-section">
        <div class="container-fluid">
            <div class="row">
                <div class="sign-col mrt-auto">
                    <div class="sign-block claim-company">
                        <div class="text-center pt-5 pb-4">
                        	@if($company->logo_url)
                            <img src="{{asset($company->logo_url)}}" alt="Logo">
                            @endif
                            <h1>{{$company->company_name}}</h1>
                            <h2>{{$company->company_tagline}}</h2>
                        </div>
                        <div class="px-4 pb-5">
                            <p class="text-center py-3 download-box w-75 mrt-auto">{{ __('company.claim_no_success') }}</p>
                            @if(!Auth::guest())
                            <div class="text-center mt-4"><a href="{{route('front.company.claim_application', $company->slug)}}" class="btn btn-blue btn-yellow">{{ __('company.claim_company_btn') }}</a></div>
                            @else
                            <div class="text-center mt-4"><a href="{{route('login')}}/?action=claim-company&name={{$company->slug}}" class="btn btn-blue btn-yellow">{{ __('company.claim_company_btn') }}</a></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection