@extends('layouts.app')

@section('content')
<div id="app">
    @include('layouts.navbar')
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        @include('layouts.sidebar');
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Pending Applications</h1>
                </div>
            </section>

            @if($user->role_id == $admin || $user->role_id == $superAdmin)
            <!-- Admin view: Show all deferred leave applications -->
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Expected Start Date</th>
                        <th scope="col">Expected End Date</th>
                        <th scope="col">HOD Approval</th>
                        <th scope="col">Final Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($leave_applications) > 0)
                        @foreach ($leave_applications as $leave)
                            @if($leave->final_approval == 'Pending')
                                <tr>
                                    <td scope="row">{{$loop->iteration}}</td>
                                    <td>{{$leave->leave_type}}</td>
                                    <td>{{$leave->start_date}}</td>
                                    <td>{{$leave->end_date}}</td>
                                    <td class="fw-bold {{ $leave->hod_approval == 'Approved' ? 'text-success' : ($leave->hod_approval == 'Defered' ? 'text-warning' : ($leave->hod_approval == 'Pending' ? 'text-warning' : 'text-danger')) }}">{{$leave->hod_approval}}</td>
                                    <td class="fw-bold {{ $leave->final_approval == 'Approved' ? 'text-success' : ($leave->final_approval == 'Defered' ? 'text-warning' : ($leave->final_approval == 'Pending' ? 'text-warning' : 'text-danger')) }}">{{$leave->final_approval}}</td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr scope="row">
                            <td colspan="6">No Record Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @elseif($user->role_id == $hod)
            <!-- HOD view: Show deferred leave applications of users in the same department -->
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Expected Start Date</th>
                        <th scope="col">Expected End Date</th>
                        <th scope="col">HOD Approval</th>
                        <th scope="col">Final Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($leave_applications) > 0)
                        @foreach ($leave_applications as $leave)
                            @if($leave->user->department == $user->department)
                                @if($leave->user->department == $user->department && $leave->final_approval == 'Pending')
                                    <tr>
                                        <td scope="row">{{$loop->iteration}}</td>
                                        <td>{{$leave->leave_type}}</td>
                                        <td>{{$leave->start_date}}</td>
                                        <td>{{$leave->end_date}}</td>
                                        <td class="fw-bold {{ $leave->hod_approval == 'Approved' ? 'text-success' : ($leave->hod_approval == 'Defered' ? 'text-warning' : ($leave->hod_approval == 'Pending' ? 'text-warning' : 'text-danger')) }}">{{$leave->hod_approval}}</td>
                                        <td class="fw-bold {{ $leave->final_approval == 'Approved' ? 'text-success' : ($leave->final_approval == 'Defered' ? 'text-warning' : ($leave->final_approval == 'Pending' ? 'text-warning' : 'text-danger')) }}">{{$leave->final_approval}}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <tr scope="row">
                            <td colspan="6">No Record Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @else
            <!-- User view: Show only user's own deferred leave applications -->
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Expected Start Date</th>
                        <th scope="col">Expected End Date</th>
                        <th scope="col">HOD Approval</th>
                        <th scope="col">Final Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($leave_applications) > 0)
                        @foreach ($leave_applications as $leave)
                            @if($leave->user_id == $user->id)
                                @if($leave->final_approval == 'Pending')
                                    <tr>
                                        <td scope="row">{{$loop->iteration}}</td>
                                        <td>{{$leave->leave_type}}</td>
                                        <td>{{$leave->start_date}}</td>
                                        <td>{{$leave->end_date}}</td>
                                        <td class="fw-bold {{ $leave->hod_approval == 'Approved' ? 'text-success' : ($leave->hod_approval == 'Defered' ? 'text-warning' : ($leave->hod_approval == 'Pending' ? 'text-warning' : 'text-danger')) }}">{{$leave->hod_approval}}</td>
                                        <td class="fw-bold {{ $leave->final_approval == 'Approved' ? 'text-success' : ($leave->final_approval == 'Defered' ? 'text-warning' : ($leave->final_approval == 'Pending' ? 'text-warning' : 'text-danger')) }}">{{$leave->final_approval}}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <tr scope="row">
                            <td colspan="6">No Record Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @endif
        </div>
       @include('layouts.footer')
    </div>
</div>
@endsection
