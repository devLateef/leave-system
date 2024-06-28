@extends('layouts.app')

@section('content')
<div id="app">
    @include('layouts.navbar')
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        @include('layouts.sidebar');
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Active Applications</h1>
                </div>
            </section>
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Expected Start Date</th>
                        <th scope="col">Expected End Date</th>
                        <th scope="col">HOD Approval</th>
                        <th scope="col">Final Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($leave_applications) > 0)
                    @foreach ($leave_applications as $leave)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$leave->leave_type}}</td>
                        <td>{{$leave->start_date}}</td>
                        <td>{{$leave->end_date}}</td>
                        <td class="text-warning fw-bold">{{$leave->hod_approval}}</td>
                        <td class="text-warning fw-bold">{{$leave->final_approval}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr scope="row">
                        <td colspan="6">No Record Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; 2024 <div class="bullet"></div> Design By <a href="#">Lateef</a>
            </div>
        </footer>
    </div>
</div>
@endsection
