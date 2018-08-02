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

							<p>Thank you for claiming <a href="{{route('front.company.show', $company->slug)}}">"{{$company->company_name}}"</a>. We were unable to verify your position within your company.
							Before we can approve your request, we need more information.</p>

							<p>Please provide verification in one of the following ways:</p>
							
							<p>
							Option 1: Email from a verifiable owner, director, or C-level employee at your company. The email should come from the executive's email address and include:
							<ul>
								<li> The executive's name, title and contact information</li>
								<li> Your name, title and work email</li>
								<li> A statement that they agree you can speak on behalf of the company on SMBeez as a company representative</li>
							</ul>
							</p>
							<p>
								Option 2: Copy of trade license, service license, commercial registration, or shareholder certificate showing your name as the authorized manager or representative of the company.
							</p>
							<p>
								Please send this information to <b>verification@masharee3.com</b>
							</p>
							<p>We look forward to welcoming you to Masharee3!</p>
							<p>Thank You,</p>
							<p>Your friends at Masharee3.</p>
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
