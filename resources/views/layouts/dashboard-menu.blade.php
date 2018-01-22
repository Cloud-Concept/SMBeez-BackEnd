<ul class="nav navbar-nav">
	@if($hascompany)
    <li class="nav-item"><a class="nav-link" href="{{route('front.user.myprojects', $user->username)}}">My Projects</a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('front.user.opportunities', $user->username)}}">My Opportunities</a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('front.company.edit', $user->company->slug)}}">My company</a></li>
    @else
    <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#add-company">Add My company</a></li>
    @endif
    <li class="nav-item"><a class="nav-link" href="{{route('front.messages.index')}}">Messages</a></li>
    <li class="nav-item"><a class="nav-link" href="">Bookmarks</a></li>
    <li class="nav-item"><a class="nav-link" href="">Settings</a></li>
</ul>