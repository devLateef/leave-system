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
        $is_super_admin = Auth::user()->role_id == 4;
        $is_admin = Auth::user()->role_id == 3;
        $is_hod = Auth::user()->role_id == 2;
        if($user == $is_super_admin || $user == $is_admin){
            $leave_applications = Leave::all();
        }else{
            $leave_applications = Leave::where('user_id', $user->id)->get();
        }
        
        return view('home', compact(['leave_applications', 'is_super_admin', 'is_hod']));
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
