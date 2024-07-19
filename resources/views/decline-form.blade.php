@extends('layouts.app')
@section('content')
    {{-- <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">State
                    Reason for Declining</h5>
                <button type="button" class="btn-close" onclick="history.back(); return false;"></button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{route('comments.decline')}}">
                    @csrf
                    <input type="number" class="form-control d-none" id="leave_id" value="{{$leave->id}}" name="leave_id">
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Reason:</label>
                        <textarea class="form-control" id="message-text" name="message"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary bg-danger"
                            onclick="history.back(); return false;">Close</button>
                        <button type="submit" class="btn btn-primary">Okay</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary mt-4">
                    <div class="card-header d-flex justify-content-between">
                        <h4>State Reason for Declining this Request!</h4>
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
                        <form method="POST" action="{{route('comments.decline')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="message-text">Reason:</label>
                                    <textarea class="form-control" id="message-text" name="message"></textarea>
                                </div>
                                <input type="number" class="form-control d-none" id="leave_id" value="{{$leave->id}}" name="leave_id">
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary btn-lg btn-inline-block">
                                    Approve Now
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
@endsection