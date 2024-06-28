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
                        <h4>Apply for Leave</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{route('store')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Leave Type</label>
                                    <select class="form-control selectric" name="leave_type">
                                        <option value="0">Select Option</option>
                                        <option value="Casual Leave">Casual Leave</option>
                                        <option value="Annual Leave">Annual Leave</option>
                                        <option value="Leave of Absence">Leave of Absence</option>
                                        <option value="Research Leave">Research Leave</option>
                                        <option value="Examination Leave">Examination Leave</option>
                                        <option value="Maternity Leave">Maternity Leave</option>
                                        <option value="Paternity Leave">Paternity Leave</option>
                                        <option value="Sabbatical Leave">Sabbatical Leave</option>
                                        <option value="Sick Leave">Sick Leave</option>
                                        <option value="Study Leave">Study Leave</option>
                                        <option value="Training Leave">Training Leave</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="start_date">Expected Start Date</label>
                                    <input id="start_date" type="date" class="form-control"
                                        name="start_date" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="end_date" class="d-block">Expected End Date</label>
                                    <input id="end_date" type="date" class="form-control"
                                        name="end_date" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="designation">Present Designation</label>
                                    <input id="designation" type="text" class="form-control"
                                        name="designation" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="standin" class="d-block">Stand in Staff While on
                                        Leave</label>
                                    <input id="standin" type="text" class="form-control"
                                        name="standin_staff">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Comment</label>
                                <textarea id="comment" class="form-control" name="comment"
                                    rows="5"></textarea>
                                <div class="invalid-feedback">
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
@endsection
