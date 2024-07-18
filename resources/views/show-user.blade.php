@extends('layouts.app')

@section('content')
<div id="app">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <div class="main-sidebar sidebar-style-2">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Profile</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a
                                href="{{route('home')}}">Dashboard</a></div>
                        <div class="breadcrumb-item">Profile</div>
                    </div>
                </div>
                <div class="section-body">
                    <h2 class="section-title">Hi, {{$user->first_name}}!</h2>
                    <p class="section-lead">
                        See information about a user on this page.
                    </p>

                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-5">

                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Profile Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <dd>First Name</dd>
                                            <dl>{{$user->first_name}}</dl>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Last Name</dd>
                                            <dl>{{$user->last_name}}</dl>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Staff ID</dd>
                                            <dl>{{$user->staff_id}}</dl>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Date of Birth</dd>
                                            <dl>{{$user->dob}}</dl>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Phone</dd>
                                            <dl>{{$user->phone}}</dl>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Department</dd>
                                            <dl>{{$user->department}}</dl>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Gender</dd>
                                            <dl>{{$user->gender}}</dl>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>State of Origin</dd>
                                            <dl>{{$user->state_of_origin}}</dl>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Employee Type</dd>
                                            <dl>{{$user->employee_type}}</dl>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <dd> Leave Balance</dd>
                                            <dl>{{$user->leave_balance}}</dl>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Is Academic Staff?</dd>
                                            @if($user->is_academic_staff == 1)
                                            <dl>Yes</dl>
                                            @else
                                            <dl>No</dl>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Staff Level</dd>
                                            <dl>{{$user->staff_level}}</dl>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <dd>Address</dd>
                                            <dl>{{$user->address}}</dl>
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- <div class="form-group col-md-12 col-12">
                                            <a href="#" class="btn btn-primary">Edit User</a>
                                        </div> --}}
                                        <div class="form-group col-md-12 col-12">
                                            <a class="btn btn-info text-white" href="{{route('profile.users-detail', $user->id)}}">Edit User</a>
                                        </div>
                                        <div class="form-group col-md-12 col-12">
                                            <form action="{{route('profile.delete', $user->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('layouts.footer')
    </div>
</div>
@endsection
