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
                        <div class="breadcrumb-item active"><a
                                href="{{route('home')}}">Dashboard</a></div>
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
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Leave Type</dt>
                                                <dd>{{$leave->leave_type}}</dd>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Department</dt>
                                                <dd>{{$leave->department}}</dd>
                                            </div>
                                        </div>
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
                                                <dt>Comment</dt>
                                                <dd>{{$leave->comment}}</dd>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <dd>Current Status</dd>
                                                <dl>{{$leave->status}}</dl>
                                            </div>
                                        </div>
                                    </dl>
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
                            <form method="POST" action="{{route('store')}}">
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
                            <form method="GET">
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
                                <div class="mb-3">
                                    <label for="message-text"
                                        class="col-form-label">Reason:</label>
                                    <textarea class="form-control" id="message-text" name="reason"></textarea>
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
                            <form method="GET">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Reason:</label>
                                    <textarea class="form-control" id="message-text" name="reason"></textarea>
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
