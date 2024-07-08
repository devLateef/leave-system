<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('home')}}">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item">
                <a href="{{route('home')}}" class="nav-link text-body"><i
                        class="fa fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown text-body" data-toggle="dropdown"><i
                        class="fa fa-columns"></i> <span>Leave Management</span></a>
                <ul class="dropdown-menu" style="display: none;">
                    <li><a class="nav-link" href="{{route('leaves.apply')}}">Request for Leave</a></li>
                    <li><a class="nav-link" href="{{route('leaves.active')}}">Approved Leaves</a></li>
                    <li><a class="nav-link" href="{{route('leaves.defered')}}">Deferred Leaves</a></li>
                    <li><a class="nav-link" href="{{route('leaves.declined')}}">Declined Leaves</a></li>
                    <li><a class="nav-link" href="{{route('leaves.pending')}}">Pending Leaves</a></li>
                </ul>
            </li>
            @if(Auth::check() && Auth::user()->role_id == config('roles.ADMIN') || Auth::user()->role_id == config('roles.SUPER_ADMIN') || Auth::user()->role_id == config('roles.HOD'))
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown text-body" data-toggle="dropdown"><i
                        class="fa fa-user"></i>
                    <span>User Management</span></a>
                <ul class="dropdown-menu" style="display: none;">
                    @if(Auth::user()->role_id == config('roles.HOD'))
                    <li><a class="nav-link" href="{{route('profile.all-users')}}">Fetch All Users</a></li>
                    @elseif(Auth::user()->role_id == config('roles.SUPER_ADMIN'))
                    <li><a class="nav-link" href="{{route('profile.create')}}">Add New User</a></li>
                    <li><a class="nav-link" href="{{route('profile.assign')}}">Assign HOD</a></li>
                    <li><a class="nav-link" href="{{route('profile.make-admin')}}">Assign Admin</a></li>
                    <li><a class="nav-link" href="{{route('profile.all-hods')}}">Fetch All HOD(s)</a></li>
                    <li><a class="nav-link" href="{{route('profile.all-users')}}">Fetch All Users</a></li>
                    @else
                    <li><a class="nav-link" href="{{route('profile.create')}}">Add New User</a></li>
                    <li><a class="nav-link" href="{{route('profile.assign')}}">Assign HOD</a></li>
                    <li><a class="nav-link" href="{{route('profile.all-hods')}}">Fetch All HOD(s)</a></li>
                    <li><a class="nav-link" href="{{route('profile.all-users')}}">Fetch All Users</a></li>
                    @endif
                </ul>
            </li>
            @endif
        </ul>
    </aside>
</div>
