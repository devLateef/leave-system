@extends('layouts.app');
@include('layouts.navbar')
@include('layouts.sidebar');
@section('content')
<section class="section">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">

                <div class="card card-primary mt-4">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Apply for Leave</h4>
                        <h6 class="text-primary">Remaining Leaves (in days):- &nbsp <b class="text-black display-6 font-weight-bold">{{$user->leave_balance}}</b>
                        </h6>
                    </div>

                    <div class="card-body">
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
                        @if (session('message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form method="POST" id="applyForm" action="{{route('leaves.store')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Leave Type</label>
                                    <select class="form-control selectric" name="leave_type" required>
                                        <option value="">Select Option</option>
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
                                    <label for="standin" class="d-block">Stand in Staff While on Leave</label>
                                    <input id="standin" type="text" class="form-control"
                                        name="standin_staff" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea id="comment" class="form-control" name="comment"
                                    rows="5" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function disableWeekends(date) {
        var day = date.getDay();
        return (day !== 0 && day !== 6); // Sunday = 0, Saturday = 6
    }

    $(document).ready(function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date').setAttribute('min', today);
        document.getElementById('end_date').setAttribute('min', today);

        // Ensure the end date is always after the start date
        document.getElementById('start_date').addEventListener('change', function() {
            var startDate = this.value;
            document.getElementById('end_date').setAttribute('min', startDate);
        });

        $('input[type="date"]').each(function() {
            $(this).attr('onfocus', 'this.blur();'); // Prevent manual typing

            $(this).on('change', function() {
                var inputDate = new Date($(this).val());
                if (!disableWeekends(inputDate)) {
                    alert('Weekends are not allowed.');
                    $(this).val(''); // Clear the invalid date
                }
            });
        });

        document.getElementById('applyForm').addEventListener('submit', function(event) {
            var startDate = new Date(document.getElementById('start_date').value);
            var endDate = new Date(document.getElementById('end_date').value);

            if (!disableWeekends(startDate) || !disableWeekends(endDate)) {
                alert('Weekends are not allowed.');
                event.preventDefault(); // Prevent form submission
            }
        });
    });
</script>
@endsection