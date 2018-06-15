<div class="sidebar-updates">
    <h5 class="title-blue">Actions</h5>
    <ul class="list-group">
        <li class="list-group-item"><a href="{{route('admin.dashboard')}}" class="{{ Request::is('admin/dashboard') ? 'active' : 'no' }}">Overview</a></li>
        <li class="list-group-item"><a href="{{route('admin.user.index')}}" class="{{ Request::is('admin/manage/users') ? 'active' : 'no' }}">User</a></li>
        <li class="list-group-item"><a href="{{route('admin.companies')}}" class="{{ Request::is('admin/manage/companies') ? 'active' : 'no' }}">Companies</a></li>
        <!-- <li class="list-group-item"><a href="">Reviews</a></li> -->
        <li class="list-group-item"><a href="{{route('admin.projects')}}" class="{{ Request::is('admin/manage/projects') ? 'active' : 'no' }}">Projects</a></li>
        <li class="list-group-item"><a href="{{route('admin.industries')}}" class="{{ Request::is('admin/manage/industries') ? 'active' : 'no' }}">Industries</a></li>
        <li class="list-group-item"><a href="{{route('admin.specialities')}}" class="{{ Request::is('admin/manage/specialities') ? 'active' : 'no' }}">Specialites</a></li>
        <li class="list-group-item"><a href="{{route('import.export.view')}}" class="{{ Request::is('admin/import-export-view') ? 'active' : 'no' }}">Import/Export</a></li>
        <li class="list-group-item"><a href="{{route('callcenter.reports')}}" class="{{ Request::is('admin/callcenter-reports') ? 'active' : 'no' }}">Call Center Reports</a></li>
        <li class="list-group-item"><a href="{{route('callcenter.reports.details')}}" class="{{ Request::is('admin/callcenter-details') ? 'active' : 'no' }}">Call Center Details</a></li>
        <!-- <li class="list-group-item"><a href="">Gamification & Rewards</a></li>
        <li class="list-group-item"><a href="">Support Tickets (123)</a></li>
        <li class="list-group-item"><a href="">Settings</a></li> -->
    </ul>
</div>