<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Leave::class);
        return view('apply');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $available_leaves = $user->available_leaves;
        $request->validate([
            'start_date' => ['required', 'date', function($attribute, $value, $fail) {
                $dayOfWeek = SupportCarbon::parse($value)->dayOfWeek;
                if ($dayOfWeek == SupportCarbon::SUNDAY || $dayOfWeek == SupportCarbon::SATURDAY) {
                    $fail('The start date cannot be a weekend.');
                }
            }],
            'end_date' => ['required', 'date', function($attribute, $value, $fail) {
                $dayOfWeek = SupportCarbon::parse($value)->dayOfWeek;
                if ($dayOfWeek == SupportCarbon::SUNDAY || $dayOfWeek == SupportCarbon::SATURDAY) {
                    $fail('The end date cannot be a weekend.');
                }
            }],
            'designation' => 'required|string',
            'standin_staff' => 'required|string',
            'comment' => 'required|string'
        ]);

        // Calculate total days requested
        $startDate = SupportCarbon::parse($request->start_date);
        $endDate = SupportCarbon::parse($request->end_date);
        $totalDaysRequested = $startDate->diffInDays($endDate) + 1; // Include the start date
        if($totalDaysRequested <= $available_leaves){
            $new_leave = new Leave();
            $new_leave->leave_type = $request->leave_type;
            $new_leave->start_date = $request->start_date;
            $new_leave->end_date = $request->end_date;
            $new_leave->total_days_requested = $totalDaysRequested;
            $new_leave->designation = $request->designation;
            $new_leave->standin_staff = $request->standin_staff;
            $new_leave->comment = $request->comment;
            $new_leave->user_id = Auth::user()->id;
            $new_leave->save();
            return redirect()->route('home')->with('success', 'Leave applied successfully.');
        }elseif($user->role_id == config('roles.SUPER_ADMIN')){
            $new_leave = new Leave();
            $new_leave->leave_type = $request->leave_type;
            $new_leave->start_date = $request->start_date;
            $new_leave->end_date = $request->end_date;
            $new_leave->total_days_requested = $totalDaysRequested;
            $new_leave->designation = $request->designation;
            $new_leave->standin_staff = $request->standin_staff;
            $new_leave->comment = $request->comment;
            $new_leave->user_id = Auth::user()->id;
            $new_leave->save();
            return redirect()->route('home')->with('success', 'Leave applied successfully.');
        }else{
            return redirect()->back()->with('message', 'Sorry: You have exhausted your available leaves.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        $user = Auth::user();
        if($user->role_id == config('roles.ADMIN') || $user->role_id == config('roles.SUPER_ADMIN'))
        {
            $this->authorize('viewAny', Leave::class);
        }elseif ($user->role_id == config('roles.HOD')) {
            $leave_applications = Leave::whereHas('user', function($query) use ($user) {
                $query->where('department', $user->department);
            })->get();
        }else{
            $this->authorize('view', $leave);
        }
        return view('show-leave', compact('leave'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        return view('edit-leave', compact('leave'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        $leave->leave_type = $request->leave_type;
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->designation = $request->designation;
        $leave->standin_staff = $request->standin_staff;
        $leave->comment = $request->comment;
        $leave->user_id = Auth::user()->id;
        $leave->save();
        return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }

    public function approved(){
        $user = Auth::user();
        $superAdmin = config('roles.SUPER_ADMIN');
        $admin = config('roles.ADMIN');
        $hod = config('roles.HOD');
        if ($user->role_id == config('roles.ADMIN') || $user->role_id == config('roles.SUPER_ADMIN')) {
        $leave_applications = Leave::where('final_approval', 'Approved')->get();
        } elseif ($user->role_id == config('roles.HOD')) {
        $leave_applications = Leave::whereHas('user', function($query) use ($user) {
            $query->where('department', $user->department);
        })->get();
        } else {
        $leave_applications = Leave::where('user_id', $user->id)->get();
        }
        return view('active-request', compact(['leave_applications', 'superAdmin', 'admin', 'hod', 'user']));
    }

    public function defered(){
        $user = Auth::user();
        $superAdmin = config('roles.SUPER_ADMIN');
        $admin = config('roles.ADMIN');
        $hod = config('roles.HOD');
        if ($user->role_id == config('roles.ADMIN') || $user->role_id == config('roles.SUPER_ADMIN')) {
            $leave_applications = Leave::where('final_approval', 'Defered')->get();
        } elseif ($user->role_id == config('roles.HOD')) {
            $leave_applications = Leave::whereHas('user', function($query) use ($user) {
                $query->where('department', $user->department);
            })->get();
        } else {
            $leave_applications = Leave::where('user_id', $user->id)->get();
        }
        return view('defer-leave', compact(['leave_applications', 'admin', 'hod', 'superAdmin', 'user']));
    }

    public function declined(){
        $user = Auth::user();
        $superAdmin = config('roles.SUPER_ADMIN');
        $admin = config('roles.ADMIN');
        $hod = config('roles.HOD');
        if ($user->role_id == config('roles.ADMIN') || $user->role_id == config('roles.SUPER_ADMIN')) {
            $leave_applications = Leave::where('final_approval', 'Declined')->get();
        } elseif ($user->role_id == config('roles.HOD')) {
            $leave_applications = Leave::whereHas('user', function($query) use ($user) {
                $query->where('department', $user->department);
            })->get();
        } else {
            $leave_applications = Leave::where('user_id', $user->id)->get();
        }
        return view('decline-leave', compact(['leave_applications', 'admin', 'hod', 'superAdmin', 'user']));
    }

    public function pending(){
        $user = Auth::user();
        $superAdmin = config('roles.SUPER_ADMIN');
        $admin = config('roles.ADMIN');
        $hod = config('roles.HOD');
        if ($user->role_id == config('roles.ADMIN') || $user->role_id == config('roles.SUPER_ADMIN')) {
        $leave_applications = Leave::where('final_approval', 'Pending')->get();
        } elseif ($user->role_id == config('roles.HOD')) {
        $leave_applications = Leave::whereHas('user', function($query) use ($user) {
            $query->where('department', $user->department);
        })->get();
        } else {
        $leave_applications = Leave::where('user_id', $user->id)->get();
        }
        return view('pending-request', compact(['leave_applications', 'superAdmin', 'admin', 'hod', 'user']));
    }

    public function approvalNote(Leave $leave){
        $user = Auth::user();
        if($user->role_id == config('roles.ADMIN') || $user->role_id == config('roles.SUPER_ADMIN'))
        {
            $this->authorize('viewAny', Leave::class);
        }elseif ($user->role_id == config('roles.HOD')) {
            $leave_applications = Leave::whereHas('user', function($query) use ($user) {
                $query->where('department', $user->department);
            })->get();
        }else{
            $this->authorize('view', $leave);
        }
        return view('approval-note', compact('leave'));
    }
}
