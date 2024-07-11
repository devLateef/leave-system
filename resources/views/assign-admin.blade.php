@extends('layouts.app')
@include('layouts.navbar')
@include('layouts.sidebar')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary mt-4">
                    <div class="card-header">
                        <h4>Assign HOD Role</h4>
                    </div>

                    <div class="card-body">
                        <form id="hodForm" method="POST" action="{{route('profile.assign-admin')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="department">Select Department:</label>
                                    <select id="department" name="department" class="form-control selectric" required>
                                        <option value="">Select Option</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->department }}">{{ $department->department }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="user">Staff List:</label>
                                    <select id="user" name="user_id" class="form-control selectric" required>
                                        <option value="">Select Option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="hod">Make Admin</label>
                                    <select id="hod" name="role_id" class="form-control selectric" required>
                                        <option value="">Choose Option</option>
                                        <option value="3">YES</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="simple-footer">
                    Copyright &copy; Lateef 2024
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#department').on('change', function() {
                var department = this.value;
                $('#user').html('<option value="">Select Staff</option>');
                if (department) {
                    $.ajax({
                        url: '/profile/users/' + department,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#user').append('<option value="'+ value.id +'">'+ value.first_name + ' ' + value.last_name +'</option>');
                                // console.log(value)
                            });
                             // Refresh the selectric dropdown
                             $('#user').selectric('refresh');
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText)
                        }
                    });
                }
            });
        });

        document.getElementById('hodForm').addEventListener('submit', function(event) {
        var userType = document.getElementById('hod').value;
        if (userType == "") {
            alert('Please select a valid option.');
            event.preventDefault(); // Prevent form submission
        }
    });
    </script>    
</section>
@endsection
