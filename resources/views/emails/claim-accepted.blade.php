@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url'), 'logo' => asset('images/common/logo.svg')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    <table class="panel" width="100%" cellpadding="0" cellspacing="0">
	    <tr>
	        <td class="panel-content">
	            <table width="100%" cellpadding="0" cellspacing="0">
	                <tr>
	                    <td class="panel-item">
	                        <h1>Hello!</h1>

							<p>Thank you for claiming <a href="{{route('front.company.show', $company->slug)}}">"{{$company->company_name}}"</a>. We are happy to confirm that your request is approved! </p>

							<p>Welcome to Masharee3!</p>
							
							<p>
							Now you can <a href="{{route('login')}}/?action=add-project">create & publish </a> new projects. 
							</p>
	                    </td>
	                </tr>
	            </table>
	        </td>
	    </tr>
	</table>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} Cloud Concept DMCC. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
