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
                            <p class="text-center py-3">{{ __('company.claim_app_title') }}</p>
                        </div>
                        <div class="px-4 pb-5">
                            <form action="{{route('front.company.claim', $company->slug)}}" method="POST" class="form-signin my-4" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ __('company.company_role') }}:</label>
                                            <select name="role" class="form-control custom-select d-block" required>
                                                <option value="Company Owner">{{ __('company.company_owner') }}</option>
                                                <option value="General Manager">{{ __('company.general_manager') }}</option>
                                                <option value="Sales and/or Marketing Director">{{ __('company.sales') }}</option>
                                                <option value="Account Manager">{{ __('company.other') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>{{ __('company.documents') }}:</label>
                                            <label class="form-control custom-file"><input type="file" id="document" name="document[]" class="custom-file-input" accept=".jpg, .png, .doc, .docx, .xlsx, .xls,text/plain, application/pdf" multiple required> <span class="custom-file-control" data-label="Registration Document"></span></label>
                                            <p class="form-guide">{{ __('company.claim_docs_hint') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>{{ __('company.additional_comments') }}:</label>
                                        <div class="form-group"><textarea class="form-control" name="comments" placeholder="{{ __('company.additional_comments') }}"></textarea></div>
                                    </div>
                                </div>
                                <div class="text-center mt-4"><button type="submit" class="btn btn-blue btn-yellow">{{ __('company.claim_company_btn') }}</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection