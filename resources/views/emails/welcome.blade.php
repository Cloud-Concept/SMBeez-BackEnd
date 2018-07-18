@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
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

							<p>Congratulations! You created a new account on masharee3.com.<!--  Please click the below link to verify your email address. --> </p>

							<p>What next? </p>

							<h3>Here is how you can make most of your Masharee3 account:</h3>
							<ul>
								<li>Browse business opportunities in your industry</li>
								<li>Create and publish a new project and earn [number] honeycombs!</li>
								<li>Submit a company review and earn [number] honeycombs!</li>
								<li>Claim your company and update your company details</li>
							</ul>

							<p>
							Your friends at Masharee3 
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
