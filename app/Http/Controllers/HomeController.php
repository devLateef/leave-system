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
        $leave_applications = Leave::all();
        $user_id = Auth::user()->role_id;
        return view('home', compact('leave_applications', 'user_id'));
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
