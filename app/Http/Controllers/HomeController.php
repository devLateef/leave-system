<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $superAdmin = env('SUPER_ADMIN');
        $admin = env('ADMIN');
        $hod = env('HOD');
        if($user->role_id == $superAdmin || $user->role_id == $admin){
            $total_leaves = Leave::count();
            $approved_leaves = Leave::where('final_approval', 'Approved')->count();
            $declined_leaves = Leave::where('final_approval', 'Declined')->count();
            $pending_leaves = Leave::where('final_approval', 'Pending')->count();
            $defered_leaves = Leave::where('final_approval', 'Defered')->count();
        }elseif($user->role_id == $hod){
            
            $total_leaves = Leave::whereHas('user', function ($query) use ($user) {
                $query->where('department', $user->department);
            })->count();
            $approved_leaves = Leave::whereHas('user', function ($query) use ($user) {
                $query->where('department', $user->department);
            })->where('final_approval', 'Approved')->count();
            $declined_leaves = Leave::whereHas('user', function ($query) use ($user) {
                $query->where('department', $user->department);
            })->where('final_approval', 'Declined')->count();
            $pending_leaves = Leave::whereHas('user', function ($query) use ($user) {
                $query->where('department', $user->department);
            })->where('final_approval', 'Pending')->count();
            $defered_leaves = Leave::whereHas('user', function ($query) use ($user) {
                $query->where('department', $user->department);
            })->where('final_approval', 'Defered')->count();
        }else{
            $total_leaves = Leave::where('user_id', $user->id)->count();
            $approved_leaves = Leave::where('user_id', $user->id)->where('final_approval', 'Approved')->count();
            $declined_leaves = Leave::where('user_id', $user->id)->where('final_approval', 'Declined')->count();
            $pending_leaves = Leave::where('user_id', $user->id)->where('final_approval', 'Pending')->count();
            $defered_leaves = Leave::where('user_id', $user->id)->where('final_approval', 'Defered')->count();
        }
        if ($user) {
            if($user->role_id == $superAdmin || $user->role_id == $admin){
                $leave_applications = Leave::all();
            }elseif($user->role_id == $hod){
                $leave_applications = Leave::whereHas('user', function($query) use ($user) {
                    $query->where('department', $user->department);
                })->get();
            }else{
                $leave_applications = Leave::where('user_id', $user->id)->get();
            }
            
            return view('home', compact(['leave_applications', 'superAdmin', 'admin', 'hod', 'user', 
            'approved_leaves', 'pending_leaves', 'declined_leaves', 'defered_leaves', 'total_leaves']));
        } else {
            // Handle the case where $user is null
            return redirect()->route('login')->withErrors('You need to be logged in to view leave applications.');
        }
    }

    public function show()
    {
        $user = Auth::user();
        return view('show-profile', compact('user'));
    }

    public function edit()
    {
        return view('edit-profile');
    }
}
