@extends('layouts.app')

@section('content')
<div id="app">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            @include('partials.flash-messages')
            <section class="section">
                <div class="section-header">
                    <h1>Dashboard</h1>
                </div>
                <div class="row">
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
                </div>
            </section>
            <table id="leavesTable" class="table table-striped table-hover table-responsive-md">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Expected Start Date</th>
                        <th scope="col">Expected End Date</th>
                        <th scope="col">HOD Approval</th>
                        <th scope="col">Final Approval</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($leave_applications) > 0)
                    @foreach ($leave_applications as $leave)
                    <tr class="clickable" role="button" onclick="window.location='{{route('leaves.show', $leave->id)}}'">
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$leave->leave_type}}</td>
                        <td>{{$leave->start_date}}</td>
                        <td>{{$leave->end_date}}</td>
                        <td class="fw-bold {{ $leave->hod_approval == 'Approved' ? 'text-success' : ($leave->hod_approval == 'Defered' ? 'text-warning' : ($leave->hod_approval == 'Pending' ? 'text-warning' : 'text-danger')) }}">{{$leave->hod_approval}}</td>
                        <td class="fw-bold {{ $leave->final_approval == 'Approved' ? 'text-success' : ($leave->final_approval == 'Defered' ? 'text-warning' : ($leave->final_approval == 'Pending' ? 'text-warning' : 'text-danger')) }}">{{$leave->final_approval}}</td>
                        <td>
                            @if($user->role_id == $superAdmin || $user->role_id == $admin || $user->role_id == $hod)
                            <a href="{{route('leaves.show', $leave->id)}}"><button class="btn btn-primary m-2">Show Details</button></a>
                            @elseif($leave->hod_approval == 'Pending' || $leave->final_approval == 'Pending')
                            <a href="{{route('leaves.show', $leave->id)}}"><button class="btn btn-primary">Show</button></a>
                            <a href="{{route('leaves.edit', $leave->id)}}"><button class="btn btn-danger">Edit</button></a>
                            @else
                            <a href="{{route('leaves.show', $leave->id)}}"><button class="btn btn-primary">Show</button></a>
                            @endif
                        </td>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Referrer-Policy': 'no-referrer-when-downgrade'
            }
        });

        $('#leavesTable').DataTable({
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('leaves.data') }}",
                "type": "GET", // Change this to POST if your server expects a POST request
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            "columns": [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'full_name', name: 'full_name' },
                { data: 'leave_type', name: 'leave_type' },
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                { data: 'hod_approval', name: 'hod_approval' },
                { data: 'final_approval', name: 'final_approval' },
                { 
                    "data": 'action', 
                    "name": 'action', 
                    "orderable": false, 
                    "searchable": false,
                    "render": function (data, type, full, meta) {
                        return full.action; // Assuming 'action' is rendered HTML in the backend
                    }
                }
            ],
            "order": [[1, 'desc']],
        });
    });
</script>
@endsection
