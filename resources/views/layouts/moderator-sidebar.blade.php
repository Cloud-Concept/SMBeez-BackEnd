<div class="sidebar-updates">
    <h5 class="title-blue">Actions</h5>
    <ul class="list-group">
    	<li class="list-group-item"><a href="{{route('moderator.companies.mycompanies', Auth::user()->username)}}" class="{{ Request::is('admin/dashboard/moderator/mycompanies/*') ? 'active' : 'no' }}">My Companies</a></li>
        <li class="list-group-item"><a href="{{route('moderator.companies.dashboard')}}" class="{{ Request::is('admin/dashboard/moderator/companies') ? 'active' : 'no' }}">All Companies</a></li>
        <li class="list-group-item"><a href="{{route('moderator.projects.dashboard')}}" class="{{ Request::is('admin/dashboard/moderator/projects') ? 'active' : 'no' }}">Projects</a></li>
    </ul>
</div>