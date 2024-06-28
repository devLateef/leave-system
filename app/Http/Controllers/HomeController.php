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
            
            return view('home', compact(['leave_applications', 'superAdmin', 'admin', 'hod', 'user']));
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
