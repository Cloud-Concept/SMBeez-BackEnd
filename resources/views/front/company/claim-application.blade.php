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
                            <p class="text-center py-3">Please fill the information below to claim this company. <br>We will review your request and contact you back.</p>
                        </div>
                        <div class="px-4 pb-5">
                            <form action="{{route('front.company.claim', $company->slug)}}" method="POST" class="form-signin my-4" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Your Company Role *:</label>
                                            <select name="role" class="form-control custom-select d-block" required>
                                                <option value="Company Owner">Company Owner</option>
                                                <option value="General Manager">General Manager</option>
                                                <option value="Sales and/or Marketing Director">Sales and/or Marketing Director</option>
                                                <option value="Account Manager">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Documents *:</label>
                                            <label class="form-control custom-file"><input type="file" id="document" name="document[]" class="custom-file-input" accept=".jpg, .png, .doc, .docx, .xlsx, .xls,text/plain, application/pdf" multiple required> <span class="custom-file-control" data-label="Registration Document"></span></label>
                                            <p class="form-guide">*Upload your scanned business card, trade license, shareholder certificate, or a company authorization letter.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Additional Comments:</label>
                                        <div class="form-group"><textarea class="form-control" name="comments" placeholder="Additional Comments"></textarea></div>
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