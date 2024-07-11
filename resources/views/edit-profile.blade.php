@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div id="app">
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
                        <div class="breadcrumb-item active"><a href="{{route('home')}}"><h6>Dashboard</h6></a></div>
                        <div class="breadcrumb-item">Profile</div>
                    </div>
                </div>
                <div class="section-body">
                    <h2 class="section-title">Hi, {{$user->first_name}}!</h2>
                    <p class="section-lead">
                        Change information about yourself on this page.
                    </p>

                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-5">

                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <form method="post" class="needs-validation" novalidate="" action="{{route('profile.update-user', $user->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-header">
                                        <h4>Edit Profile</h4>
                                    </div>
                                    <div class="card-body">
                                        @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="first_name"
                                                    value="{{$user->first_name}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the first name
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{$user->last_name}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the last name
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-7 col-12">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{$user->email}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the email
                                                </div>
                                            </div>
                                            <div class="form-group col-md-5 col-12">
                                                <label>Phone</label>
                                                <input type="tel" class="form-control" name="phone" 
                                                    value="{{$user->phone}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12 col-12">
                                                <label>Address</label>
                                                <textarea class="form-control" name="address" rows="5">{{$user->address}}</textarea>
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
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
