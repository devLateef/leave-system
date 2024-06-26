<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leave_applications = Leave::all();
        return view('active-request', compact('leave_applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('apply');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_leave = new Leave();
        $new_leave->leave_type = $request->leave_type;
        $new_leave->department = $request->department;
        $new_leave->start_date = $request->start_date;
        $new_leave->end_date = $request->end_date;
        $new_leave->designation = $request->designation;
        $new_leave->standin_staff = $request->standin_staff;
        $new_leave->comment = $request->comment;
        $new_leave->user_id = Auth::user()->id;
        $new_leave->save();
        return redirect(route('home'));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        $this->authorize('create', $leave);
        return view('show-leave', compact('leave'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
    public function approve(Request $request, Leave $leave){
        //
    }
}
