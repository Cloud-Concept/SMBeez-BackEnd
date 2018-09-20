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
							مبروك! شرك “{{$interest->project->user->company->company_name}}” - قامت بقبولك لمشروع “{{$interest->project->project_title}}”. لإتمام التعاقد من العميل عليك التواصل مع العميل عن طريق مشاريع أو بالإتصال بالعميل مباشرة لمناقشة تفاصيل التعاقد. 
							</p>
							
							<p {{$rtl}}>ماذا بعد؟</p>

							<p {{$rtl}}>لا تضيع الوقت! أتصل مباشرةً بالعميل <a href="{{route('front.company.show', $interest->project->user->company->slug)}}?utm_source=newsletter&utm_medium=email&utm_campaign=call_center">{{$interest->project->user->company->company_name}}</a>! إضغط <a href="{{route('front.company.show', $interest->project->user->company->slug)}}?utm_source=newsletter&utm_medium=email&utm_campaign=call_center">هنا</a> للوصول إلى بروفايل العميل. </p></p>

							<p {{$rtl}}>بسرعة! العميل ينتظرك!</p>

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
            &copy; {{ date('Y') }} Cloud Concept DMCC. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
