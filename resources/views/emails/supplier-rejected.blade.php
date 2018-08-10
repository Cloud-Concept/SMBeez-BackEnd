@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{asset('images/common/email-header.png')}}" style="width:100%;height:auto;"/>
        @endcomponent
    @endslot

    <table class="panel" width="100%" cellpadding="0" cellspacing="0">
	    <tr>
	        <td class="panel-content">
	            <table width="100%" cellpadding="0" cellspacing="0">
	                <tr>
	                    <td class="panel-item">
	                    	<?php $rtl = 'style=text-align:right!important;'; ?>
	                        <h1 {{$rtl}}>مرحباً</h1>

							<p {{$rtl}}>للأسف تم رفضك لمشروع "{{$interest->project->project_title}}". لا داعي للإحباط: هناك عدة أسباب تؤدي للرفض ويمكنك معالجتها: </p>

							<p {{$rtl}}>* قد يكون بروفايل شركتك غير كامل. قم بإكمال بروفايل شركتك هنا وأحصل على نقاط إضافية في حسابك. </p>
							<p {{$rtl}}>* قد تكون التقييمات عن شركتك قليلة العدد أو منخفضة. أطلب من زبائنك ومورديك أن يعطوا تقييماتهم لشركتك هنا. </p>
							<p {{$rtl}}>* قد تكون فرصة المشروع غير ذات صلة بخبرة شركتك أو مجال عملها. قم بتحديث خبرات شركتك هنا. </p>

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
            &copy; {{ date('Y') }} Cloud Concept DMCC. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
