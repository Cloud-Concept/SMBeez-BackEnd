@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        
    @endslot

    <table class="panel" width="100%" cellpadding="0" cellspacing="0" style="direction:rtl" direction="rtl">
	    <tr>
    		<td><img src="https://www.masharee3.com/images/common/email-header.png" style="width:100%;height:auto;"/></td>
    	</tr>
	    <tr>
	        <td class="panel-content">
	            <table width="100%" cellpadding="0" cellspacing="0">
	                <tr>
	                    <td class="panel-item">
	                    	<?php $rtl = 'style=text-align:right!important;'; ?>
	                        <h1 {{$rtl}}>مرحباً</h1>

							<p {{$rtl}}>
							عندك موردين مهتمين بتنفيذ مشروع <a href="{{route('front.project.show', $project->slug)}}">"{{$project->project_title}}"</a> ، ممكن تبص عليهم من <a href="{{route('front.user.myprojects', $project->user->username)}}">هنا</a>. علشان تقدر تحدد هتقبل مين ينفذلك المشروع.
							</p>

							<p {{$rtl}}>
								ماتنساش انك تعمل تقييمات للموردين اللي هتشوفهم.
							</p>
							<p {{$rtl}}>
							أصدقاءك في مشاريع 
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
        	<a href="https://www.masharee3.com?utm_source=newsletter&utm_medium=email&utm_campaign=call_center" title="">https://www.masharee3.com</a><br>
            &copy; {{ date('Y') }} masharee3.com. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
