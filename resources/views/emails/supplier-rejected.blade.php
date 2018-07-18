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

							<p>Unfortunately you have been declined for "{{$interest->project->project_title}}". You need not despair: a declined response might be due to several reasons: </p>

							<p>* Your company profile might be incomplete. Complete your profile here and get more honeycombs that you can redeem for valuable things later! </p>
							<p>* Your reviews might be too few or not high enough. Ask your customers and suppliers to submit reviews about your company here. </p>
							<p>* The opportunity might be unrelated to your expertise. Update your industry and specialities here. </p>

							<p>Good luck!</p>

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
