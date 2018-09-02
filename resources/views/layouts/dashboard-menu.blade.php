<ul class="nav navbar-nav">
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/profile/*') ? 'active' : 'no' }}" href="{{route('front.user.editprofile', $user->username)}}">{{__('general.settings')}}</a></li>
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/messages/all') ? 'active' : 'no' }}" href="{{route('front.messages.index')}}">{{__('general.messages')}}</a></li>
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/bookmarks') ? 'active' : 'no' }}" href="{{route('front.bookmarks.list')}}">{{__('general.bookmarks')}}</a></li>
	@if($hascompany)
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('companies/*/edit') ? 'active' : 'no' }}" href="{{route('front.company.edit', $user->company->slug)}}">{{__('general.edit_my_company')}}</a></li>
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/dashboard/*/myprojects') ? 'active' : 'no' }}" href="{{route('front.user.myprojects', $user->username)}}">{{__('general.my_projects')}}</a></li>
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/dashboard/*/opportunities') ? 'active' : 'no' }}" href="{{route('front.user.opportunities', $user->username)}}">{{__('general.my_opportunities')}}</a></li>
    @elseif(!$hascompany && !count($user->claims) > 0)
    <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#add-company">{{__('general.add_company_button')}}</a></li>
    @endif
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/dashboard/*') ? 'active' : 'no' }}" href="{{route('front.user.dashboard', $user->username)}}"><i class="fa fa-home"></i></a></li>
</ul>
<script>
/*$(document).ready(function(e) { 
    var $mainContent = $('.cd-main-content');
    var $catLinks = $('.dashboard-nav .ajax-item a');
    $catLinks.on('click', function(e) {
    e.preventDefault(); 
    $el = $(this);
    var value = $el.attr("href");
    $mainContent.animate({opacity: "0.5"});
    $mainContent.load(value + " .dashboard" , function() {
        $mainContent.animate({opacity: "1"});
        });
        return false;
    }); 
});*/
</script>