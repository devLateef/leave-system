<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container ml-0">
        <a class="navbar-brand text-body" href="{{ url('/') }}">
            {{-- {{ config('app.name', 'Home') }} --}}
            Home
        </a>
        <button class="navbar-toggler absolute" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav md-auto d-lg-none d-xl-none d-md-inline d-sm-inline">
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

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto d-md-inline d-sm-inline">
                <!-- Authentication Links -->
                <li class="dropdown mr-5">
                    <a href="#" data-toggle="dropdown"
                        class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}"
                            class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block text-body">{{ Auth::user()->first_name }}
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">  
                        <a href="{{route('profile.show')}}" class="dropdown-item has-icon">
                            <i class="far fa-user"></i> Profile
                        </a>
                        <a href="{{route('profile.edit')}}" class="dropdown-item has-icon">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <a href="{{route('profile.change')}}" class="dropdown-item has-icon">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    {{-- <div class="modal fade" id="approveModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Complete the form
                                to Approve</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <dt>Expected Start Date</dt>
                                    
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <dt>Expected End Date</dt>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div> --}}
</nav>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
