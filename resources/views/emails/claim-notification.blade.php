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

							<p>A new claim request has been sent for company “{{$company->company_name}}”. </p>

							<p>Kindly check the claims section for further information.</p>
							
							<p>
							Masharee3.com 
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
