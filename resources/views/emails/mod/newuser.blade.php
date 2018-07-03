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
	                        <h1>Welcome to Masharee3.</h1>

	                        <p>Login Email: {{$user->email}}</p>
							<p>Login Password: {{$unique_password}}</p>
							<p>Link: <a href="http://www.masharee3.com/login">http://www.masharee3.com/login</a></p>
							<p>Below is your company URL: ({{route('front.company.show', $user->company->slug)}})</p>
							
							<p>What next? </p>

							<h3>Here is how you can make most of your Masharee3 account:</h3>
							<ol>
								<li>Complete your company profile.</li>
								<li>Browse business opportunities in your industry.</li>
								<li>Create and publish a new project and get interested suppliers on it.</li>
							</ol>

							<p>
							Thanks,
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
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent