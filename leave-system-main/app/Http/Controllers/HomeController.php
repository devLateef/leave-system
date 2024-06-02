<?php

namespace App\Http\Controllers;

use App\Models\Leave;
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
        return view('home', compact('leave_applications'));
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
