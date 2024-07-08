@extends('layouts.app');
@include('layouts.navbar')
@include('layouts.sidebar');
@section('content')
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
                                    <label for="country">Country:</label>
                                    <select id="country" name="country" class="form-control selectric" required>
                                        <option value="">Choose Option</option>
                                        <option value="Nigeria">Nigeria</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="city">City:</label>
                                    <select id="city" name="city" class="form-control selectric" required>
                                        <option value="">Choose Option</option>
                                        <option value="Abeokuta">Abeokuta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="academic_staff">Is Academic Staff?:</label>
                                    <select id="academic_staff" name="is_academic_staff" class="form-control selectric" required>
                                        <option value="">Choose Option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
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
                <div class="simple-footer">
                    Copyright &copy; Lateef 2024
                </div>
            </div>
        </div>
    </div>
</section>
<script>

    document.getElementById('userForm').addEventListener('submit', function(event) {
        var userType = document.getElementById('country').value;
        if (userType == '') {
            alert('Please select a valid country type.');
            event.preventDefault(); // Prevent form submission
        }
    });
    
    // // Create a new Headers object
    // var headers = new Headers();
    // headers.append("X-CSCAPI-KEY", "API_KEY");  // Replace with your actual API key

    // // Set the request options
    // var requestOptions = {
    //     method: 'GET',
    //     headers: headers,
    //     redirect: 'follow'
    // };

    // // Perform the fetch request
    // fetch("https://api.countrystatecity.in/v1/countries/IN/states", requestOptions)
    //     .then(response => {
    //         // Check if the response status is OK (status 200-299)
    //         if (!response.ok) {
    //             throw new Error('Network response was not ok ' + response.statusText);
    //         }
    //         return response.json(); // Parse the JSON from the response
    //     })
    //     .then(result => console.log(result)) // Log the result to the console
    //     .catch(error => console.log('Fetch error: ', error)); // Log any errors that occur
</script>
@endsection
