<ul class="nav navbar-nav">
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/dashboard/*') ? 'active' : 'no' }}" href="{{route('front.user.dashboard', $user->username)}}"><i class="fa fa-home"></i></a></li>
	@if($hascompany)
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/dashboard/*/myprojects') ? 'active' : 'no' }}" href="{{route('front.user.myprojects', $user->username)}}">My Projects</a></li>
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/dashboard/*/opportunities') ? 'active' : 'no' }}" href="{{route('front.user.opportunities', $user->username)}}">My Opportunities</a></li>
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('companies/*/edit') ? 'active' : 'no' }}" href="{{route('front.company.edit', $user->company->slug)}}">Edit my company</a></li>
    @elseif(!$hascompany && !count($user->claims) > 0)
    <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#add-company">Add My company</a></li>
    @endif
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/messages/all') ? 'active' : 'no' }}" href="{{route('front.messages.index')}}">Messages</a></li>
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/bookmarks') ? 'active' : 'no' }}" href="{{route('front.bookmarks.list')}}">Bookmarks</a></li>
    <li class="nav-item ajax-item"><a class="nav-link {{ Request::is('user/profile/*') ? 'active' : 'no' }}" href="{{route('front.user.editprofile', $user->username)}}">Settings</a></li>
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