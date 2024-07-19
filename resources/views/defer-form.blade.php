@extends('layouts.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary mt-4">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Complete the Below Form to Defer this Request</h4>
                        <button type="button" class="btn-close" onclick="history.back(); return false;"></button>
                    </div>
                    <div class="card-body">
                        <div class="row ml-1">
                            <div class="form-group col-md-6 col-12">
                                <dt>Expected Start Date</dt>
                                <dd>{{$leave->start_date}}</dd>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <dt>Expected End Date</dt>
                                <dd>{{$leave->end_date}}</dd>
                            </div>
                        </div>
                        <div class="row ml-1">
                            <div class="form-group col-md-6 col-12">
                                <dt>Total Number of Days Requested</dt>
                                <dd>{{$leave->total_days_requested}}</dd>
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <dt>HOD Approval</dt>
                                <dd class="fw-bold text-white text-center {{$leave->hod_approval == 'Approved' ? 'bg-success w-51 p-1 rounded' : ($leave->hod_approval == 'Defered' ? 'bg-info w-50 p-1 rounded' : ($leave->hod_approval == 'Pending' ? 'bg-warning w-50 p-1 rounded' : 'bg-danger w-50 p-1 rounded'))}}">{{$leave->hod_approval}}</dd>
                            </div>
                        </div>
                        <div class="row ml-1">
                            <div class="form-group col-md-6 col-12">
        
                                <div>
                                    @php
                                        $hodComment = null;
                                    @endphp
                                    @if($leave->hod_approval == 'Pending')
                                    <div></div>
                                    @else
                                    <dt>HOD {{$leave->hod_approval}} Details:</dt>
                                    @foreach($leave->comments as $comment)
                                        @if($comment->leave_id == $leave->id && $comment->user->role_id == config('roles.HOD'))
                                            @php
                                                $hodComment = $comment;
                                            @endphp
                                        @elseif($comment->leave_id == $leave->id && $comment->user->role_id == config('roles.SUPER_ADMIN'))
                                            @php
                                            $hodComment = $comment;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @endif
                                    @if($hodComment)
                                        @if($leave->hod_approval == 'Declined')
                                        <dd class="mt-2"><em><=== Reason for {{$leave->hod_approval}}: ===></em> <br> <b>{{$hodComment->message}}</b></dd>
                                        @else
                                        <dd class="mt-2"><em>{{$leave->hod_approval}} Start Date:</em> <b>{{$hodComment->start_date}}</b></dd>
                                        <dd><em>{{$leave->hod_approval}} End Date:</em> <b>{{$hodComment->end_date}}</b></dd>
                                        <hr>
                                        <dd><em>Comment:</em> <b>{{$hodComment->message}}</b></dd>
                                            @if($leave->hod_approval == 'Approved')
                                            <dd><em>Days Approved:</em> <b>{{$hodComment->days_given}} Days</b></dd>
                                            @endif
                                        <hr/>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <div>
                                    @php
                                        $finalComment = null;
                                    @endphp
                                    @if($leave->final_approval == 'Pending')
                                    <div></div>
                                    @else
                                    <dt>Admin {{$leave->final_approval}} Details:</dt>
                                    @foreach($leave->comments as $comment)
                                        @if($comment->leave_id == $leave->id && $comment->user->role_id == config('roles.ADMIN'))
                                            @php
                                                $finalComment = $comment;
                                            @endphp
                                        @elseif($comment->leave_id == $leave->id && $comment->user->role_id == config('roles.SUPER_ADMIN'))
                                            @php
                                            $finalComment = $comment;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @endif
                                    @if($finalComment)
                                        @if($leave->final_approval == 'Declined')
                                        <dd class="mt-2"><em><=== Reason for {{$leave->final_approval}}: ===></em> <br> <b>{{$finalComment->message}}</b></dd>
                                        @else
                                        <dd class="mt-2"><em>{{$leave->final_approval}} Start Date:</em> <b>{{$finalComment->start_date}}</b></dd>
                                        <dd><em>{{$leave->final_approval}} End Date:</em> <b>{{$finalComment->end_date}}</b></dd>
                                        <hr>
                                        <dd><em>Comment:</em> <b>{{$finalComment->message}}</b></dd>
                                            @if($leave->final_approval == 'Approved')
                                            <dd><em>Days Approved:</em> <b>{{$finalComment->days_given}} Days</b></dd>
                                            @endif
                                        <hr/>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{route('comments.defer')}}" id="deferForm">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="defer_start_date">Defer Start Date:</label>
                                    <input type="date" class="form-control date-input" id="defer_start_date" name="start_date">
                                </div>
                                <input type="hidden" id="approve_leave_id" name="leave_id" value="{{$leave->id}}">
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="defer_end_date">Defer End Date:</label>
                                    <input type="date" class="form-control date-input" id="defer_end_date" name="end_date">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="approve_message">Message:</label>
                                    <textarea class="form-control" id="defer_message" name="message"></textarea>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary btn-lg btn-inline-block">
                                    Defer Now
                                </button>
                                <button  class="btn btn-danger btn-lg btn-inline-block" onclick="history.back(); return false;">
                                    Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>
    <script>
        function disableWeekends(date) {
            var day = date.getDay();
            return (day !== 0 && day !== 6); // Sunday = 0, Saturday = 6
        }

        $(document).ready(function() {
            var today = new Date().toISOString().split('T')[0];
            var expected_start_date = '{{ $leave->start_date }}';

            // Set the minimum date for all date inputs
            $('.date-input').attr('min', today);

            // Ensure the end date is always after the start date
            $('#approve_start_date').on('change', function() {
                var startDate = $(this).val();
                $('#approve_end_date').attr('min', startDate);
            });

            // Ensure the end date is always after the start date
            $('#defer_start_date').on('change', function() {
                var startDate = $(this).val();
                $('#defer_end_date').attr('min', startDate);
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

            // Validate form submission
            $('#deferForm').on('submit', function(event) {
                var startDate = new Date($('#approve_start_date').val());
                var endDate = new Date($('#approve_end_date').val());

                if (!disableWeekends(startDate) || !disableWeekends(endDate)) {
                    alert('Weekends are not allowed.');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
@endsection