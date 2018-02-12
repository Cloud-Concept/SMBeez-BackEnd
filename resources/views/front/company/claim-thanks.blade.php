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
                            <p class="text-center w-75 mrt-auto download-box">Thank you for your request. Will send you future instruction to verify your ownership of this company.</p>
                            <div class="text-center mt-4"><a href="{{route('front.company.show', $company->slug)}}" class="btn btn-blue btn-yellow">Go Back</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection