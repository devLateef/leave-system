@extends('layouts.app')

@section('content')
<div id="app">
    <div class="main-wrapper">
        @include('layouts.navbar')
        <div class="navbar-bg"></div>
        @include('layouts.sidebar');
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-2">
                            <div class="card-icon bg-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Approved Leaves</h4>
                                </div>
                                <div class="card-body">
                                    47
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-2">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-history"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Pending Leaves</h4>
                                </div>
                                <div class="card-body">
                                    10
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-2">
                            <div class="card-icon bg-danger">
                                <i class="far fa-times-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Declined Leaves</h4>
                                </div>
                                <div class="card-body">
                                    42
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-2">
                            <div class="card-icon bg-primary">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Applications</h4>
                                </div>
                                <div class="card-body">
                                    {{count($leave_applications)}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <table class="table table-striped table-hover table-responsive-md">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Expected Start Date</th>
                        <th scope="col">Expected End Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($leave_applications) > 0)
                    @foreach ($leave_applications as $leave)
                    <tr class="clickable" role="button" onclick="window.location='{{route('show-leave', $leave->id)}}'">
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$leave->leave_type}}</td>
                        <td>{{$leave->start_date}}</td>
                        <td>{{$leave->end_date}}</td>
                        <td class="text-warning fw-bold">{{$leave->status}}</td>
                        <td>
                            <a href="{{route('show-leave', $leave->id)}}"><button class="btn btn-primary">Show Details</button></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr scope="row">
                        <td colspan="6">No Record Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @include('layouts.footer')
    </div>
</div>
@endsection
