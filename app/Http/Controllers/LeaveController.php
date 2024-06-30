<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $user = Auth::user();
        if($user->role_id == config('roles.ADMIN') || $user->role_id == config('roles.SUPER_ADMIN')){
            $this->authorize('viewAny', Leave::class);
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
}
