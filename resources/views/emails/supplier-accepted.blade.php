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

							<p>
							Congratulations - you have been accepted for opportunity “{{$interest->project->project_title}}”. This doesn’t yet mean you have been awarded the contract; it means you have been approved to contact the client for further discussions. 
							</p>
							
							<p>What next?</p></p></p>

							<p>Don’t wait! Reach out directly to <a href="{{route('front.company.show', $interest->project->user->company->slug)}}">{{$interest->project->user->company->company_name}}</a>! Click <a href="{{route('front.company.show', $interest->project->user->company->slug)}}">here</a> to get access to their profile and contact details. </p></p>

							<p>Hurry! They are waiting for you!</p>

							<p>
							Your friends at SMBeez 
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
