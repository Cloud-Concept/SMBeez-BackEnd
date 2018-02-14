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
                            <p class="text-center py-3">Please fill the infomartion below to claim this company.<br>We will contact you for future infomration.</p>
                        </div>
                        <div class="px-4 pb-5">
                            <form action="{{route('front.company.claim', $company->slug)}}" method="POST" class="form-signin my-4" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="role" placeholder="Your Company Role" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-control custom-file"><input type="file" id="document" name="document" class="custom-file-input" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf" required> <span class="custom-file-control" data-label="Registration Document"></span></label>
                                            <p class="form-guide">Upload your company registration documents to get a verified badge on your company profile</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group"><textarea class="form-control" name="comments" placeholder="Additional Comments" required></textarea></div>
                                    </div>
                                </div>
                                <div class="text-center mt-4"><button type="submit" class="btn btn-blue btn-yellow">Claim Company</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection