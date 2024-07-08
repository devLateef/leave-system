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
                    <h1>Leave Approval Note</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active">
                            <a href="#" onclick="history.back(); return false;">
                                <h6>Go Back</h6>
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
                                            <h4>Approval Confirmation Details</h4>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Full Name</dt>
                                                <dd>{{$leave->user->first_name}} {{$leave->user->last_name}}</dd>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Leave Type</dt>
                                                <dd>{{$leave->leave_type}}</dd>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @php
                                                $adminComment = null;
                                            @endphp
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Start Date</dt>
                                                @foreach($leave->comments as $comment)
                                                    @php
                                                        $adminComment = $comment;
                                                    @endphp
                                                @endforeach
                                                @if($adminComment)
                                                <dd>{{$adminComment->start_date}}</dd>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <dt>End Date</dt>
                                                <dd>{{$adminComment->end_date}}</dd>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Department</dt>
                                                @if($leave->user)
                                                <dd>{{$leave->user->department}}</dd>
                                                @else
                                                <dd>No Department Found</dd>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Days Approved</dt>
                                                <dd>{{$admin->days_given}}</dd>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Status</dt>
                                                <dd class="fw-bold text-center text-white {{$leave->final_approval == 'Approved' ? 'bg-success w-25 p-1 rounded' : ($leave->final_approval == 'Defered' ? 'bg-warning w-25 p-1 rounded' : ($leave->final_approval == 'Pending' ? 'bg-warning w-25 p-1 rounded' : 'bg-danger w-25 p-1 rounded'))}}">{{$leave->final_approval}}</dd>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <dt>Leave Balance:</dt>
                                                <dd>{{$leave->user->available_leaves - $admin->days_given}}</dd>
                                                @endif
                                            </div>
                                        </div>
                                    </dl>
                                </div>
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
