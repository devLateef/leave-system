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
            <table class="table table-striped table-hover table-responsive-md">
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
                        <td>
                            <a href="#"><button class="btn btn-primary mb-1 mt-1">Show</button></a>
                            <a href="#"><button class="btn btn-danger mb-1">Delete</button></a>
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
@endsection
