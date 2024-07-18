@extends('layouts.app');
@include('layouts.navbar')
@include('layouts.sidebar');
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div
                class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                {{-- <div class="login-brand">
                    <img src="{{asset('assets/img/stisla-fill.svg')}}" alt="logo" width="100"
                        class="shadow-light rounded-circle">
                </div> --}}

                <div class="card card-primary mt-4">
                    <div class="card-header">
                        <h4>Register New User</h4>
                    </div>
                    @if ($errors->any())
                        <div class="text-white alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-body">
                        <form id="userForm" method="POST" action="{{route('profile.store')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="first_name">First Name:</label>
                                    <input id="first_name" type="text" class="form-control"
                                        name="first_name" required>
                                </div>
                                <div class="form-group col-4">
                                    <label for="last_name">Last Name:</label>
                                    <input id="last_name" type="text" class="form-control"
                                        name="last_name" required>
                                </div>
                                <div class="form-group col-4">
                                    <label for="staff_id">Staff ID</label>
                                    <input id="staff_id" type="text" class="form-control"
                                        name="staff_id" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="department">Department:</label>
                                    <select id="department" name="department" class="form-control selectric" required>
                                        <option value="">Choose Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->department}}">{{$department->department}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="email" class="d-block">Staff Email:</label>
                                    <input id="email" type="email" class="form-control"
                                        name="email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="gender" class="d-block">Gender:</label>
                                    <select id="gender" name="gender" class="form-control selectric" required>
                                        <option value="">Select Option</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="dob">Date of Birth:</label>
                                    <input id="dob" type="date" class="form-control"
                                        name="dob" required>
                                </div>
                                
                                <div class="form-group col-4">
                                    <label for="phone">Phone Number:</label>
                                    <input id="phone" type="tel" class="form-control"
                                        name="phone" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="staff_level">Staff Level:</label>
                                    <select id="staff_level" name="staff_level" class="form-control selectric" required>
                                        <option value="">Choose Option</option>
                                        <option value="Level 1">Level 1</option>
                                        <option value="Level 2">Level 2</option>
                                        <option value="Level 3">Level 3</option>
                                        <option value="Level 4">Level 4</option>
                                        <option value="Level 5">Level 5</option>
                                        <option value="Level 6">Level 6</option>
                                        <option value="Level 7">Level 7</option>
                                        <option value="Level 8">Level 8</option>
                                        <option value="Level 9">Level 9</option>
                                        <option value="Level 10">Level 10</option>
                                        <option value="Level 11">Level 11</option>
                                        <option value="Level 12">Level 12</option>
                                        <option value="Level 13">Level 13</option>
                                        <option value="Level 14">Level 14</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="state_of_origin">State of Origin:</label>
                                    <select id="state_of_origin" name="state_of_origin" class="form-control selectric" required>
                                        <option value="">Choose Option</option>
                                        <option value="Abia">Abia</option>
                                        <option value="Adamawa">Adamawa</option>
                                        <option value="Akwa Ibom">Akwa Ibom</option>
                                        <option value="Anambra">Anambra</option>
                                        <option value="Bauchi">Bauchi</option>
                                        <option value="Bayelsa">Bayelsa</option>
                                        <option value="Benue">Benue</option>
                                        <option value="Borno">Borno</option>
                                        <option value="Cross River">Cross River</option>
                                        <option value="Delta">Delta</option>
                                        <option value="Ebonyi">Ebonyi</option>
                                        <option value="Edo">Edo</option>
                                        <option value="Ekiti">Ekiti</option>
                                        <option value="Enugu">Enugu</option>
                                        <option value="FCT - Abuja">FCT - Abuja</option>
                                        <option value="Gombe">Gombe</option>
                                        <option value="Imo">Imo</option>
                                        <option value="Jigawa">Jigawa</option>
                                        <option value="Kaduna">Kaduna</option>
                                        <option value="Kano">Kano</option>
                                        <option value="Katsina">Katsina</option>
                                        <option value="Kebbi">Kebbi</option>
                                        <option value="Kogi">Kogi</option>
                                        <option value="Kwara">Kwara</option>
                                        <option value="Lagos">Lagos</option>
                                        <option value="Nasarawa">Nasarawa</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Ogun">Ogun</option>
                                        <option value="Ondo">Ondo</option>
                                        <option value="Osun">Osun</option>
                                        <option value="Oyo">Oyo</option>
                                        <option value="Plateau">Plateau</option>
                                        <option value="Rivers">Rivers</option>
                                        <option value="Sokoto">Sokoto</option>
                                        <option value="Taraba">Taraba</option>
                                        <option value="Yobe">Yobe</option>
                                        <option value="Zamfara">Zamfara</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="academic_staff">Is Academic Staff?:</label>
                                    <select id="academic_staff" name="is_academic_staff" class="form-control selectric" required>
                                        <option value="">Choose Option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="employee_type">Employee Type:</label>
                                    <select id="employee_type" name="employee_type" class="form-control selectric" required>
                                        <option value="">Choose Option</option>
                                        <option value="Full Time">Full Time</option>
                                        <option value="Contract">Contract</option>
                                        <option value="Associate">Associate</option>
                                        <option value="Sabbatical">Sabbatical</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="leave_balance">Leave Balance:</label>
                                    <input id="leave_balance" type="number" class="form-control"
                                        name="leave_balance" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="address">Address:</label>
                                    <textarea id="address" class="form-control" name="address"
                                        rows="5"></textarea>
                                    <div class="invalid-feedback">
                                    </div>
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
                @include('layouts.footer')
            </div>
        </div>
    </div>
</section>
<script>

    document.getElementById('userForm').addEventListener('submit', function(event) {
        var userType = document.getElementById('state_of_origin').value;
        if (userType == '') {
            alert('Please select a valid country type.');
            event.preventDefault(); // Prevent form submission
        }
    });
</script>
@endsection
