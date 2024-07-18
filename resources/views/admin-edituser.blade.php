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
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-5">

                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <form method="post" class="needs-validation" novalidate="" action="{{route('profile.adminupdate-user', $user->id)}}">
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
                                            <div class="form-group col-md-4 col-12">
                                                <label for="first_name">First Name</label>
                                                <input id="first_name" type="text" class="form-control" name="first_name"
                                                    value="{{$user->first_name}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the first name
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="last_name">Last Name</label>
                                                <input id="last_name" type="text" class="form-control" name="last_name"
                                                    value="{{$user->last_name}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the last name
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="staff_id">Staff ID</label>
                                                <input id="staff_id" type="text" class="form-control" name="staff_id"
                                                    value="{{$user->staff_id}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the staff Id
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <label for="email">Staff Email</label>
                                                <input id="email" type="email" class="form-control" name="email"
                                                    value="{{$user->email}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the email
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="phone">Phone</label>
                                                <input id="phone" type="tel" class="form-control" name="phone" 
                                                    value="{{$user->phone}}">
                                                <div class="invalid-feedback">
                                                    Please fill in the email
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="department">Department:</label>
                                                <select id="department" name="department" class="form-control selectric" required>
                                                    <option value="{{$user->department}}">{{$user->department}}</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->department}}">{{$department->department}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please fill in the department
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <label for="gender" class="d-block">Gender:</label>
                                                <select id="gender" name="gender" class="form-control selectric" required>
                                                    <option value="{{$user->gender}}">{{$user->gender}}</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please fill in the gender
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="staff_level">Staff Level:</label>
                                                <select id="staff_level" name="staff_level" class="form-control selectric" required>
                                                    <option value="{{$user->staff_level}}">{{$user->staff_level}}</option>
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
                                            <div class="form-group col-md-4 col-12">
                                                <label for="state_of_origin">State of Origin:</label>
                                                <select id="state_of_origin" name="state_of_origin" class="form-control selectric" required>
                                                    <option value="{{$user->state_of_origin}}">{{$user->state_of_origin}}</option>
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
                                            <div class="form-group col-md-4 col-12">
                                                <label for="dob">Date of Birth</label>
                                                <input id="dob" type="date" class="form-control" name="dob"
                                                    value="{{$user->dob}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the date of birth
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="leave_balance">Leave Balance</label>
                                                <input id="leave_balance" type="number" class="form-control" name="leave_balance"
                                                    value="{{$user->leave_balance}}" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the leave balance
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label for="academic_staff">Is Academic Staff?:</label>
                                                <select id="academic_staff" name="is_academic_staff" class="form-control selectric" required>
                                                    @if($user->is_academic_staff == 1)
                                                    <option value="1">Yes</option>
                                                    @else
                                                    <option value="0">No</option>
                                                    @endif
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-5 col-12">
                                                <label for="employee_type">Employee Type:</label>
                                                <select id="employee_type" name="employee_type" class="form-control selectric" required>
                                                    <option value="{{$user->employee_type}}">{{$user->employee_type}}</option>
                                                    <option value="Full Time">Full Time</option>
                                                    <option value="Contract">Contract</option>
                                                    <option value="Associate">Associate</option>
                                                    <option value="Sabbatical">Sabbatical</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-7 col-12">
                                                <label for="address">Address</label>
                                                <textarea id="address" class="form-control" name="address" rows="5">{{$user->address}}</textarea>
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
