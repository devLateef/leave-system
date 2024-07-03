<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        return view('register-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_user = new User();
        $new_user->first_name = $request->first_name;
        $new_user->last_name = $request->last_name;
        $new_user->staff_id = $request->staff_id;
        $new_user->email = $request->email;
        $new_user->gender = $request->gender;
        $new_user->dob = $request->dob;
        $new_user->department = $request->department;
        $new_user->phone = $request->phone;
        $new_user->city = $request->city;
        $new_user->country = $request->country;
        $new_user->address = $request->address;
        $new_user->save();
        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = Auth::user();
        return view('show-profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function createpass(){
        $user = Auth::user();
        return view('change-password', compact('user'));
    }
}
