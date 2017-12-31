<ul class="nav navbar-nav">
    <li class="nav-item"><a class="nav-link" href="{{route('front.user.myprojects', $user->username)}}">My Projects</a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('front.user.opportunities', $user->username)}}">My Opportunities</a></li>
    @if($hascompany)
    <li class="nav-item"><a class="nav-link" href="{{route('front.company.edit', $user->company->slug)}}">My company</a></li>
    @endif
    <li class="nav-item"><a class="nav-link" href="">Bookmarks</a></li>
    <li class="nav-item"><a class="nav-link" href="">Settings</a></li>
</ul>