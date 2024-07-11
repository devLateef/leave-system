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
                        Change your password on this page.
                    </p>

                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-5">

                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <form method="post" id="form" class="needs-validation" novalidate="" action="{{route('profile.update-password', $user->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-header">
                                        <h4>Edit Password</h4>
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
                                            <div class="form-group col-md-12 col-12">
                                                <label for="password">New Password</label>
                                                <input type="password" id="new_password" class="form-control" name="password"
                                                    value="" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the new password
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12 col-12">
                                                <label for="password_confirmation">Confirm New Password</label>
                                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                                                    value="" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the confirm password
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');

        form.addEventListener('submit', function (event) {
            if (newPassword.value !== confirmPassword.value) {
                event.preventDefault(); // Prevent form submission
                confirmPassword.setCustomValidity('Passwords do not match');
                confirmPassword.reportValidity(); // Show the custom validation message
            } else {
                confirmPassword.setCustomValidity(''); // Clear any previous custom validation messages
            }
        });

        // Optional: Add real-time validation
        confirmPassword.addEventListener('input', function () {
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
            } else {
                confirmPassword.setCustomValidity('');
            }
        });
    });
</script>
@endsection
