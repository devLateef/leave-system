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
                        <form method="POST" action="{{route('leaves.update', $leave->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Leave Type</label>
                                    <select class="form-control selectric" name="leave_type">
                                        <option value="0" {{ old('leave_type', $leave->leave_type) == '0' ? 'selected' : '' }}>Select Option</option>
                                        <option value="Casual Leave" {{ old('leave_type', $leave->leave_type) == 'Casual Leave' ? 'selected' : '' }}>Casual Leave</option>
                                        <option value="Annual Leave" {{ old('leave_type', $leave->leave_type) == 'Annual Leave' ? 'selected' : '' }}>Annual Leave</option>
                                        <option value="Leave of Absence" {{ old('leave_type', $leave->leave_type) == 'Leave of Absence' ? 'selected' : '' }}>Leave of Absence</option>
                                        <option value="Research Leave" {{ old('leave_type', $leave->leave_type) == 'Research Leave' ? 'selected' : '' }}>Research Leave</option>
                                        <option value="Examination Leave" {{ old('leave_type', $leave->leave_type) == 'Examination Leave' ? 'selected' : '' }}>Examination Leave</option>
                                        <option value="Maternity Leave" {{ old('leave_type', $leave->leave_type) == 'Maternity Leave' ? 'selected' : '' }}>Maternity Leave</option>
                                        <option value="Paternity Leave" {{ old('leave_type', $leave->leave_type) == 'Paternity Leave' ? 'selected' : '' }}>Paternity Leave</option>
                                        <option value="Sabbatical Leave" {{ old('leave_type', $leave->leave_type) == 'Sabbatical Leave' ? 'selected' : '' }}>Sabbatical Leave</option>
                                        <option value="Sick Leave" {{ old('leave_type', $leave->leave_type) == 'Sick Leave' ? 'selected' : '' }}>Sick Leave</option>
                                        <option value="Study Leave" {{ old('leave_type', $leave->leave_type) == 'Study Leave' ? 'selected' : '' }}>Study Leave</option>
                                        <option value="Training Leave" {{ old('leave_type', $leave->leave_type) == 'Training Leave' ? 'selected' : '' }}>Training Leave</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="start_date">Expected Start Date</label>
                                    <input id="start_date" type="date" class="form-control"
                                        name="start_date" value="{{ old('start_date', $leave->start_date) }}" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="end_date" class="d-block">Expected End Date</label>
                                    <input id="end_date" type="date" class="form-control"
                                        name="end_date" value="{{ old('end_date', $leave->end_date) }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="designation">Present Designation</label>
                                    <input id="designation" type="text" class="form-control"
                                        name="designation" value="{{ old('designation', $leave->designation) }}" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="standin" class="d-block">Stand in Staff While on
                                        Leave</label>
                                    <input id="standin" type="text" class="form-control"
                                        name="standin_staff" value="{{ old('standin_staff', $leave->standin_staff) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea id="comment" class="form-control" name="comment"
                                    rows="5">{{ old('comment', $leave->comment) }}</textarea>
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
                @include('layouts.footer')
            </div>
        </div>
    </div>
</section>
@endsection
