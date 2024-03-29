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

							<p {{$rtl}}>للأسف تم رفضك لمشروع "{{$interest->project->project_title}}". لا داعي للإحباط: هناك عدة أسباب ممكن تؤدي للرفض و تقدر تعالجها: </p>

							<p {{$rtl}}>* ممكن يكون بروفايل شركتك غير كامل. كمّل بروفايل شركتك. </p>
							<p {{$rtl}}>* ممكن تكون التقييمات عن شركتك قليلة العدد أو منخفضة. أطلب من عملائك و موردينك أنهم يعملوا تقييماتهم لشركتك. </p>
							<p {{$rtl}}>* ممكن تكون فرصة المشروع ملهاش علاقة بخبرة شركتك أو مجال عملها. قم بتحديث خبرات شركتك. </p>

							<p {{$rtl}}>لو محتاج مساعدة في اي شئ اتصل بمدير الحساب الخاص بيك من فريق مشاريع.كوم و هنساعدك عشان تستفيد من الموقع اكتر.</p>
							
							<p {{$rtl}}>حظ سعيد!</p>

							<p {{$rtl}}>
							أصدقائك في مشاريع 
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
