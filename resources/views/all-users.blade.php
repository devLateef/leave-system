@extends('layouts.app')

@section('content')
<div id="app">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: #2983e9;
        color: white;
        border: none;
        padding: 5px 10px !important;
        margin: 0 4px !important;
        cursor: pointer;
        border-radius: 4px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #0056b3;
    color: white;
    }
    .dataTables_wrapper .dataTables_paginate {
    text-align: center;
    margin-top: 20px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #0056b3;
        color: white;
    }
    /* Style the DataTable search bar */
    .dataTables_filter {
        text-align: left; /* Align the search bar to the left */
        margin-bottom: 15px; /* Add space below the search bar */
    }
    .dataTables_filter label {
    font-weight: bold !important; /* Make the label bold */
    color: #333 !important; /* Change label color */
    }
    .dataTables_filter input {
    width: 300px; /* Set a fixed width */
    padding: 10px; /* Add padding */
    border: 1px solid #ddd; /* Add border */
    border-radius: 10px; /* Round the corners */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
    outline: none; /* Remove default outline */
    transition: all 0.3s ease; /* Smooth transition */
    }
    .dataTables_filter input:focus {
    border-color: #007BFF; /* Change border color on focus */
    box-shadow: 0px 2px 5px rgba(0, 123, 255, 0.5); /* Change shadow on focus */
    }
    </style>
    <div class="main-wrapper">
        @include('layouts.navbar')
        <div class="navbar-bg"></div>
        @include('layouts.sidebar');
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>All Users</h1>
                </div>
                {{-- <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="{{route('leaves.active')}}">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Approved Leaves</h4>
                                    </div>
                                    <div class="card-body">
                                        {{$approved_leaves}}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="{{route('leaves.pending')}}">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-warning">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Pending Leaves</h4>
                                    </div>
                                    <div class="card-body">
                                        {{$pending_leaves}}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="{{route('leaves.declined')}}">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-danger">
                                    <i class="far fa-times-circle"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Declined Leaves</h4>
                                    </div>
                                    <div class="card-body">
                                        {{$declined_leaves}}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="{{route('leaves.defered')}}">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-info">
                                    <i class="far fa-user"></i>
                                </div>
                                
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Defered Leaves</h4>
                                    </div>
                                    <div class="card-body">
                                        {{$defered_leaves}}
                                    </div>
                                </div>
                            </div>
                    </a>
                    </div>
                </div> --}}
            </section>
            <table id="usersTable" class="table table-striped table-hover table-responsive-md">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Staff ID</th>
                        <th scope="col">Department</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users) > 0)
                    @foreach ($users as $user)
                    <tr class="clickable" role="button" onclick="window.location='#'">
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$user->first_name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->staff_id}}</td>
                        <td>{{$user->department}}</td>
                        <td>{{$user->gender}}</td>
                        {{-- <td>Rendering this data dynamically with javascript</td> --}}
                    </tr>
                    @endforeach
                    @else
                    <tr scope="row">
                        <td colspan="7">No Record Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>         
        </div>
        @include('layouts.footer')
    </div>
</div>
<script>
    $(document).ready(function () {
    $('#usersTable').dataTable({
        "serverSide": true,
        "responsive": true,
        "ajax": "{{route('profile.users')}}",
        columns: [
            { data: null, name: 'sn' },
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'staff_id', name: 'staff_id' },
            { data: 'department', name: 'department' },
            { data: 'gender', name: 'gender' },
            {
                render: function(data, type, row) {
                // Construct the URL with the user ID dynamically
                var url = '{{ route("profile.user-detail", ":id") }}';
                url = url.replace(':id', row.id);
                
                return '<td><a href="' + url + '"><button class="btn btn-primary m-1">Show</button></a></td>';
                },
                orderable: false,
                searchable: false
            }
        ],
        createdRow: function (row, data, index) {
                    // Add serial number
                    $('td', row).eq(0).html(index + 1 + this.api().page.info().start);
                    }
    });
});
</script>
@endsection
