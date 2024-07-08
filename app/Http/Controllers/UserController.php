<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $departments = Department::all();
        return view('register-user', compact('departments'));
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
        $new_user->is_academic_staff = $request->is_academic_staff;
        $new_user->leave_balance = $request->leave_balance;
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
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->update();
        return redirect()->back(201)->with('success', 'User updated successfully.');
    }

    public function updatePass(Request $request, User $user)
    {
        
        // Validate the incoming request data
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // // Hash the new password
        $user->password = Hash::make($request->password);
        // // Save the updated user
        $user->update();
        // Redirect back with a success message
        return redirect()->back(201)->with('success', 'Password updated successfully.');

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

    public function assignHod(){
        return view('assign-hod');
    }

    public function getDepartments()
    {
        $departments = Department::all();
        return view('assign-hod', compact('departments'));
    }

    public function getUsersByDepartment($department)
    {
        $users = User::where('department', $department)->get(['id', 'first_name', 'last_name']);
        return response()->json($users);
    }

    //updating user role to HOD role
    public function updateRole(Request $request){
        $user = User::find($request->user_id);
        if ($user) {
            // Check if the user is already an HOD
            if ($user->role_id == 2) {
                // If user is already an HOD, update the department record to point to this user as HOD
                $department = Department::where('department', $request->department)->first();
                $department->hod_id = $user->id;
                $department->save();
                return redirect(route('home'));
            }else {
                // If the user is not an HOD, update the user's role_id
                $user->role_id = $request->role_id;
                $user->save();
                $department = Department::where('department', $request->department)->first();
                // Update the department record with the new HOD
                $department->hod_id = $user->id;
                $department->save();
                return redirect(route('home'));
            }
        }else {
            // Handle the case where the user is not found
            return redirect()->back()->withErrors(['User not found.']);
        };

    }

    public function assignAdmin(Request $request){
        $user = User::find($request->user_id);
        if ($user) {
            if ($user->role_id == 1 || $user->role_id == 2) {
                $user->role_id = $request->role_id;
                $user->save();
                return redirect(route('home'));
            }
        }else {
            // Handle the case where the user is not found
            return redirect()->back()->withErrors(['User not found.']);
        };

    }

    public function getAdminDepartment(){
        $departments = Department::all();
        return view('assign-admin', compact('departments'));
    }

    public function getAllUsers()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Ensure the authenticated user is an HOD
        if ($user->role_id == 2) { // Assuming 2 is the role ID for HOD
            // Get the department where the user is the HOD
            $department = Department::where('hod_id', $user->id)->first();

            if ($department) {
                // Fetch all users in the HOD's department
                $users = User::where('department', $department->department)->get();
                return view('all-users', compact('users'));
            } else {
                // Handle the case where the HOD has no department
                return redirect()->back()->with('error', 'You are not assigned to any department.');
            }
        } else {
            $users = User::where('role_id', '!=', 4)->get();
            return view('all-users', compact('users'));
        }
    }

    public function getAllHods(){
        $hods = Department::whereNotNull('hod_id')->with('user')->get();
        return view('all-hods', compact('hods'));
    }
}
