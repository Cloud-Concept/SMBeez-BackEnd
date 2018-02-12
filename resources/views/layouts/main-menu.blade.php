<ul class="cd-main-nav">
    <li><a href="{{route('front.company.all')}}">Companies</a></li>
    <li class="nav-item dropdown">
        <a class="nav-link" href="{{route('front.industry.index')}}">Opportunities</a>
    </li>
    <li class="nav-item dropdown flags-dropdown">
        <a href="#"><span class="flag-icon flag-icon-ae"></span> Dubai</a>
    </li>
    @if (Auth::guest())
    <li class="btn-menu"><a href="{{ route('login') }}">Sign in</a></li>
    @else
    <li class="nav-item dropdown {{Auth::user()->profile_pic_url ? 'usernav' : ''}}">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Auth::user()->profile_pic_url)
                <img src="{{asset(Auth::user()->profile_pic_url)}}">
            @else
                {{ Auth::user()->name }}
            @endif 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('front.user.dashboard', Auth::user()->username) }}">Dashboard</a>
            <a class="dropdown-item" href="{{ route('front.user.profile', Auth::user()->username) }}">Profile</a>
            @if(\Laratrust::hasRole('admin|superadmin'))
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
            @endif
            @if($hascompany && \Laratrust::hasRole('company'))
            <a class="dropdown-item" href="{{ route('front.company.show', $mycompany->slug) }}">My Company</a>
            @endif
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
    @endif
</ul>