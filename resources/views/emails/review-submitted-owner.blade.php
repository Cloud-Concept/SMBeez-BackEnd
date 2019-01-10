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

							<p {{$rtl}}>مبروك - شركتك جالها تقييم جديد! إضغط على الرابط التالي لترى التقييم: <a href="{{route('front.company.show', $review->company->slug)}}?utm_source=newsletter&utm_medium=email&utm_campaign=call_center">اضغط هنا</a> </p>

							<p {{$rtl}}>انت كمان ممكن تعمل تقييمات للشركات اللي اتعاملت معاها سواء كنت عميل أو مورد و تحكي عن تجربتك معاهم. </p>

							<p {{$rtl}}>ادخل من هنا عشان تعمل تقييمات لشركات تانية <a href="{{route('front.company.all')}}">اضغط هنا</a></p>
							
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
