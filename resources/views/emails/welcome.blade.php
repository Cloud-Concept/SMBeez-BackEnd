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

							<p {{$rtl}}>مبروك! تم فتح حسابك على مشاريع.كوم. </p>

							<p {{$rtl}}>بداية الطريق هنا! </p>

							<h3 {{$rtl}}>بعض الطرق التي هتخليك تستفيد من حسابك على مشاريع:</h3>
							<ul {{$rtl}}>
								<li {{$rtl}}>دور على فرص المشاريع في مجال عمل شركتك.</li>
								<li {{$rtl}}>دور على موردين يشتغلوا معاك.</li>
								<li {{$rtl}}>أعمل تقييمات للشركات التانية اللي اتعاملت معاها قبل كده</li>
								<li {{$rtl}}>أطلب من عملائك و موردينك انهم يقيموا شركتك على مشاريع.كوم</li>
								<li {{$rtl}}>طالب بشركتك و حدث بياناتها</li>
							</ul>

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
