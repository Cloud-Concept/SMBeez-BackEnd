@extends('layouts.inner')

@section('content')

<main class="cd-main-content signup">
    <section class="sign-section">
        <div class="container-fluid">
            <div class="row">
                <div class="sign-col mrt-auto">
                    <div class="sign-block claim-company">
                        <div class="px-4 pb-5">
                            <br><br>
                            <p class="text-center w-75 mrt-auto download-box">{{ __('company.claim_thnx_msg') }}</p>
                            <div class="text-center mt-4"><a href="{{route('front.company.show', $company->slug)}}" class="btn btn-blue btn-yellow">{{ __('company.go_back') }}</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection