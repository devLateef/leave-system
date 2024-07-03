@extends('layouts.app')

@section('content')
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
                                                <dd>{{$leave->user->name}}</dd>
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
                                                <dt>Comment</dt>
                                                <dd>{{$leave->comment}}</dd>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <dt>HOD Approval</dt>
                                                <dd class="fw-bold text-white text-center {{$leave->hod_approval == 'Approved' ? 'bg-success w-25 p-1 rounded' : ($leave->hod_approval == 'Defered' ? 'bg-warning w-25 p-1 rounded' : ($leave->hod_approval == 'Pending' ? 'bg-warning w-25 p-1 rounded' : 'bg-danger w-25 p-1 rounded'))}}">{{$leave->hod_approval}}</dd>
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
                                                <dd class="fw-bold text-center text-white {{$leave->final_approval == 'Approved' ? 'bg-success w-25 p-1 rounded' : ($leave->final_approval == 'Defered' ? 'bg-warning w-25 p-1 rounded' : ($leave->final_approval == 'Pending' ? 'bg-warning w-25 p-1 rounded' : 'bg-danger w-25 p-1 rounded'))}}">{{$leave->final_approval}}</dd>
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
                                    </dl>
                                    @if(Auth::check() && Auth::user()->role_id == config('roles.ADMIN') 
                                    || Auth::user()->role_id == config('roles.SUPER_ADMIN') || 
                                    Auth::user()->role_id == config('roles.HOD'))
                                    <div class="d-lg-flex d-md-flex justify-content-between">
                                        <button type="button"
                                            class="btn btn-primary bg-success mt-2 col-lg-2 col-md-5 col-12"
                                            data-bs-toggle="modal"
                                            data-bs-target="#approveModal">Approve Request</button>
                                        <button type="button"
                                            class="btn btn-primary bg-warning mt-2 col-lg-2 col-md-5 col-12"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deferModal">Defer Request</button>
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
                            <form method="POST" action="{{route('comments.approve')}}">
                                @csrf
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Approve Start
                                        Date:</label>
                                    <input type="date" class="form-control"
                                        id="approved_start_date" name="start_date">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Approve End
                                        Date:</label>
                                    <input type="date" class="form-control" id="approved_end_date" name="end_date">
                                </div>
                                <div class="mb-3">
                                    <label for="message-text"
                                        class="col-form-label">Message:</label>
                                    <textarea class="form-control" id="message-text" name="message"></textarea>
                                </div>
                                <input type="number" class="form-control d-none" id="leave_id" value="{{$leave->id}}" name="leave_id">
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
                            <form method="POST" action="{{route('comments.defer')}}">
                                @csrf
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Defer Start
                                        Date:</label>
                                    <input type="date" class="form-control"
                                        id="approved_start_date" name="start_date">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Defer End
                                        Date:</label>
                                    <input type="date" class="form-control" id="approved_end_date" name="end_date">
                                </div>
                                <input type="number" class="form-control d-none" id="leave_id" value="{{$leave->id}}" name="leave_id">
                                <div class="mb-3">
                                    <label for="message-text"
                                        class="col-form-label">Reason:</label>
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
@endsection
