@extends('layouts.app')

@section('content')
<div id="app">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <div class="main-sidebar sidebar-style-2">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Leave Details</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active">
                            <a href="{{route('home')}}" >
                                <h6>Dashboard</h6>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-5">
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <dl>
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <dt>Full Name</dt>
                                                <dd>{{$leave->user->first_name}} {{$leave->user->last_name}}</dd>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <dt>Leave Type</dt>
                                                <dd>{{$leave->leave_type}}</dd>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <dt>Department</dt>
                                                @if($leave->user)
                                                <dd>{{$leave->user->department}}</dd>
                                                @else
                                                <dd>No Department Found</dd>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <dt>Expected Start Date</dt>
                                                <dd>{{$leave->start_date}}</dd>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <dt>Expected End Date</dt>
                                                <dd>{{$leave->end_date}}</dd>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <dt>Total Number of Days Requested</dt>
                                                <dd>{{$leave->total_days_requested}}</dd>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <dt>Comment</dt>
                                                <dd>{{$leave->comment}}</dd>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <dt>HOD Approval</dt>
                                                <dd class="fw-bold text-white text-center {{$leave->hod_approval == 'Approved' ? 'bg-success w-25 p-1 rounded' : ($leave->hod_approval == 'Defered' ? 'bg-info w-25 p-1 rounded' : ($leave->hod_approval == 'Pending' ? 'bg-warning w-25 p-1 rounded' : 'bg-danger w-25 p-1 rounded'))}}">{{$leave->hod_approval}}</dd>
                                                <div class="mt-4">
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
                                                        <dd class="mt-2"><em>{{$leave->hod_approval}} Start Date:</em> <br> <b>{{$hodComment->start_date}}</b></dd>
                                                        <dd><em>{{$leave->hod_approval}} End Date:</em> <br> <b>{{$hodComment->end_date}}</b></dd>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <dt>Final Approval</dt>
                                                <dd class="fw-bold text-center text-white {{$leave->final_approval == 'Approved' ? 'bg-success w-25 p-1 rounded' : ($leave->final_approval == 'Defered' ? 'bg-info w-25 p-1 rounded' : ($leave->final_approval == 'Pending' ? 'bg-warning w-25 p-1 rounded' : 'bg-danger w-25 p-1 rounded'))}}">{{$leave->final_approval}}</dd>
                                                <div class="mt-4">
                                                    @php
                                                        $adminComment = null;
                                                    @endphp
                                                    @if($leave->final_approval == 'Pending')
                                                    <div></div>
                                                    @else
                                                    <dt>Admin {{$leave->final_approval}} Details:</dt>
                                                    @foreach($leave->comments as $comment)
                                                        @if($comment->leave_id == $leave->id && $comment->user->role_id == config('roles.ADMIN'))
                                                            @php
                                                                $adminComment = $comment;
                                                            @endphp
                                                        @elseif($comment->leave_id == $leave->id && $comment->user->role_id == config('roles.SUPER_ADMIN'))
                                                            @php
                                                            $adminComment = $comment;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                    @if($adminComment)
                                                        @if($leave->final_approval == 'Declined')
                                                        <dd class="mt-2"><em><=== Reason for {{$leave->final_approval}}: ===></em> <br> <b>{{$adminComment->message}}</b></dd>
                                                        @else
                                                        <dd class="mt-2"><em>{{$leave->final_approval}} Start Date:</em> <br> <b>{{$adminComment->start_date}}</b></dd>
                                                        <dd><em>{{$leave->final_approval}} End Date:</em> <br> <b>{{$adminComment->end_date}}</b></dd>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($leave->final_approval == 'Approved' && $leave->user_id == Auth::user()->id)
                                        <div class="row">
                                            <div>
                                                <a href="{{route('leaves.approval', $leave->id)}}" class="btn btn-success float-right">Click Here for Approval Note</a>
                                            </div>
                                        </div>
                                        @endif
                                    </dl>
                                    @if(Auth::check() && Auth::user()->role_id == config('roles.ADMIN') 
                                    || Auth::user()->role_id == config('roles.SUPER_ADMIN') || 
                                    Auth::user()->role_id == config('roles.HOD'))
                                    <div class="d-lg-flex d-md-flex justify-content-between">
                                        @if(Auth::id() == $leave->user_id && $leave->final_approval == 'Pending')
                                        <a href="{{route('leaves.edit', $leave->id)}}" class="btn btn-primary bg-info mt-2 col-lg-1 col-md-5 col-12 w-25 text-white">Edit</a>
                                        @endif
                                        <button type="button"
                                            class="btn btn-primary bg-success mt-2 col-lg-2 col-md-5 col-12"
                                            data-bs-toggle="modal"
                                            data-bs-target="#approveModal" id="approve_btn">Approve Request</button>
                                        <button type="button"
                                            class="btn btn-primary bg-warning mt-2 col-lg-2 col-md-5 col-12"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deferModal" id="defer_btn">Defer Request</button>
                                        <button type="button"
                                            class="btn btn-primary bg-danger mt-2 col-lg-2 col-md-5 col-12"
                                            data-bs-toggle="modal"
                                            data-bs-target="#declineModal">Decline Request</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {{-- Approve modal starts here --}}
            <div class="modal fade" id="approveModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Complete the form
                                to Approve</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <dt>Expected Start Date</dt>
                                    <dd>{{$leave->start_date}}</dd>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <dt>Expected End Date</dt>
                                    <dd>{{$leave->end_date}}</dd>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <dt>Total Number of Days Requested</dt>
                                    <dd>{{$leave->total_days_requested}}</dd>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <dt>HOD Approval</dt>
                                    <dd class="fw-bold text-white text-center {{$leave->hod_approval == 'Approved' ? 'bg-success w-51 p-1 rounded' : ($leave->hod_approval == 'Defered' ? 'bg-info w-50 p-1 rounded' : ($leave->hod_approval == 'Pending' ? 'bg-warning w-50 p-1 rounded' : 'bg-danger w-50 p-1 rounded'))}}">{{$leave->hod_approval}}</dd>    
                                </div>
                            </div>
                            <div class="row">
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
                                            <hr/>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{route('comments.approve')}}" id="approveForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="approve_start_date" class="col-form-label">Approve Start Date:</label>
                                    <input type="date" class="form-control date-input" id="approve_start_date" name="start_date">
                                </div>
                                <div class="mb-3">
                                    <label for="approve_end_date" class="col-form-label">Approve End Date:</label>
                                    <input type="date" class="form-control date-input" id="approve_end_date" name="end_date">
                                </div>
                                <div class="mb-3">
                                    <label for="approve_message" class="col-form-label">Message:</label>
                                    <textarea class="form-control" id="approve_message" name="message"></textarea>
                                </div>
                                <input type="hidden" id="approve_leave_id" name="leave_id" value="{{$leave->id}}">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary bg-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Okay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Approve modal ends here --}}

            {{-- Defer modal start here --}}
            <div class="modal fade" id="deferModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Complete the form
                                to Defer the Application</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <dt>Expected Start Date</dt>
                                    <dd>{{$leave->start_date}}</dd>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <dt>Expected End Date</dt>
                                    <dd>{{$leave->end_date}}</dd>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <dt>Total Number of Days Requested</dt>
                                    <dd>{{$leave->total_days_requested}}</dd>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <dt>HOD Approval</dt>
                                    <dd class="fw-bold text-white text-center {{$leave->hod_approval == 'Approved' ? 'bg-success w-51 p-1 rounded' : ($leave->hod_approval == 'Defered' ? 'bg-info w-50 p-1 rounded' : ($leave->hod_approval == 'Pending' ? 'bg-warning w-50 p-1 rounded' : 'bg-danger w-50 p-1 rounded'))}}">{{$leave->hod_approval}}</dd>
                                </div>
                            </div>
                            <div class="row">
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
                                            <hr/>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{route('comments.defer')}}" id="deferForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="defer_start_date" class="col-form-label">Approve Start Date:</label>
                                    <input type="date" class="form-control date-input" id="defer_start_date" name="start_date">
                                </div>
                                <div class="mb-3">
                                    <label for="defer_end_date" class="col-form-label">Approve End Date:</label>
                                    <input type="date" class="form-control date-input" id="defer_end_date" name="end_date">
                                </div>
                                <div class="mb-3">
                                    <label for="approve_message" class="col-form-label">Message:</label>
                                    <textarea class="form-control" id="defer_message" name="message"></textarea>
                                </div>
                                <input type="hidden" id="approve_leave_id" name="leave_id" value="{{$leave->id}}">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary bg-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Okay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Defer modal ends here --}}
            {{-- Decline modal starts here --}}
            <div class="modal fade" id="declineModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">State
                                reason for Declining</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <dt>Expected Start Date</dt>
                                    <dd>{{$leave->start_date}}</dd>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <dt>Expected End Date</dt>
                                    <dd>{{$leave->end_date}}</dd>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <dt>Total Number of Days Requested</dt>
                                    <dd>{{$leave->total_days_requested}}</dd>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <dt>HOD Approval</dt>
                                    <dd class="fw-bold text-white text-center {{$leave->hod_approval == 'Approved' ? 'bg-success w-51 p-1 rounded' : ($leave->hod_approval == 'Defered' ? 'bg-info w-50 p-1 rounded' : ($leave->hod_approval == 'Pending' ? 'bg-warning w-50 p-1 rounded' : 'bg-danger w-50 p-1 rounded'))}}">{{$leave->hod_approval}}</dd>
                                </div>
                            </div>
                            <div class="row">
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
                                            <hr/>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{route('comments.decline')}}">
                                @csrf
                                <input type="number" class="form-control d-none" id="leave_id" value="{{$leave->id}}" name="leave_id">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Reason:</label>
                                    <textarea class="form-control" id="message-text" name="message"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary bg-danger"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Okay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Decline modal ends here --}}
        </div>
        @include('layouts.footer')
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
            $('#approveForm').on('submit', function(event) {
                var startDate = new Date($('#approve_start_date').val());
                var endDate = new Date($('#approve_end_date').val());

                if (!disableWeekends(startDate) || !disableWeekends(endDate)) {
                    alert('Weekends are not allowed.');
                    event.preventDefault(); // Prevent form submission
                }
            });
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
