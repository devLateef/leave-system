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
                                href="{{route('home')}}"><h6>Dashboard</h6></></a></div>
                        <div class="breadcrumb-item">Profile</div>
                    </div>
                </div>
                <div class="section-body">
                    <h2 class="section-title">Hi, {{$user->first_name}}!</h2>
                    <p class="section-lead">
                        See information about yourself on this page.
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
                                            <dd>City</dd>
                                            <dl>{{$user->city}}</dl>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <dd>Country</dd>
                                            <dl>{{$user->country}}</dl>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <dd>Address</dd>
                                            <dl>{{$user->address}}</dl>
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
