<div class="sidebar-updates">
    <h5 class="title-blue">Actions</h5>
    <ul class="list-group">
    	<li class="list-group-item"><a href="{{route('moderator.companies.mycompanies', Auth::user()->username)}}" class="{{ Request::is('admin/dashboard/moderator/mycompanies/*') ? 'active' : 'no' }}">My Companies</a></li>
        <li class="list-group-item"><a href="{{route('moderator.companies.dashboard')}}" class="{{ Request::is('admin/dashboard/moderator/companies') ? 'active' : 'no' }}">All Companies</a></li>
        <li class="list-group-item"><a href="{{route('moderator.projects.dashboard')}}" class="{{ Request::is('admin/dashboard/moderator/projects') ? 'active' : 'no' }}">Projects</a></li>
        <li class="list-group-item"><a href="{{route('admin.user.logins')}}" class="{{ Request::is('admin/manage/users/logins') ? 'active' : 'no' }}">User Logins</a></li>
        <li class="list-group-item"><a href="{{route('admin.user.mod_portfolio_track', Auth::user()->username)}}" class="{{ Request::is('admin/manage/moderator-portfolio-track/*') ? 'active' : 'no' }}">My Statistics</a></li>
    </ul>
</div>