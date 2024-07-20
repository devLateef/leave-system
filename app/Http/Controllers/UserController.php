<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;

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
        $messages = [
            'staff_id.regex' => 'The staff ID is not Valid.',
            'email.unique' => 'The email has already been taken.',
            'staff_id.unique' => 'The staff ID has already been taken.',
            'dob.before_or_equal' => 'You must be at least 18 years old.',
        ];
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'staff_id' => [
                'required', 
                'string', 
                'max:20', 
                'unique:users',
                'regex:/^CUA/',
            ],
        ], $messages);
        try{
            $new_user = new User();
            $new_user->first_name = $request->first_name;
            $new_user->last_name = $request->last_name;
            $new_user->staff_id = $request->staff_id;
            $new_user->email = $request->email;
            $new_user->gender = $request->gender;
            $new_user->dob = $request->dob;
            $new_user->department = $request->department;
            $new_user->phone = $request->phone;
            $new_user->staff_level = $request->staff_level; // newly added
            $new_user->state_of_origin = $request->state_of_origin; //city to state of origin
            $new_user->is_academic_staff = $request->is_academic_staff;
            $new_user->employee_type = $request->employee_type; // country to employment_type
            $new_user->leave_balance = $request->leave_balance;
            $new_user->address = $request->address;
            $new_user->save();
            toastr()->success('success', 'New User Created Successfully');
            return redirect(route('home'));
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => 'There was a problem updating the user: ' . $e->getMessage()]);
        }
    }

    public function showUserDetail(User $user){
        return view('show-user', compact('user'));
    }

    public function showUserDetailsForEdit(User $user){
        $departments = Department::all();
        return view('admin-edituser', compact(['user', 'departments']));
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
        $departments = Department::all();
        return view('edit-profile', compact(['user', 'departments']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $messages = [
            'email.unique' => 'The email has already been taken.',
            'staff_id.unique' => 'The staff ID has already been taken.',
        ];

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], $messages);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->update();
        return redirect()->back(201)->with('success', 'User updated successfully.');
    }

    public function adminUpdate(Request $request, User $user)
    {
        $messages = [
            'staff_id.regex' => 'The staff ID is not Valid.',
            'email.unique' => 'The email has already been taken.',
            'staff_id.unique' => 'The staff ID has already been taken.',
            'dob.before_or_equal' => 'You must be at least 18 years old.',
        ];

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'staff_id' => ['required', 'string', 'max:20', 'unique:users,staff_id,' . $user->id],
        ], $messages);

        try {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->staff_id = $request->staff_id;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->department = $request->department;
            $user->phone = $request->phone;
            $user->staff_level = $request->staff_level;
            $user->state_of_origin = $request->state_of_origin;
            $user->is_academic_staff = $request->is_academic_staff;
            $user->employee_type = $request->employee_type;
            $user->leave_balance = $request->leave_balance;
            $user->address = $request->address;
            $user->save();
    
            toastr()->success('User updated successfully.');
            return redirect(route('home'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'There was a problem updating the user: ' . $e->getMessage()]);
        }
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
        try {
            DB::beginTransaction();
        
            // Find all leaves associated with the user
            $leaves = Leave::where('user_id', $user->id)->get();
        
            foreach ($leaves as $leave) {
                // Delete comments associated with each leave
                $leave->comments()->delete();
            }
        
            // Delete all leaves associated with the user
            Leave::where('user_id', $user->id)->delete();
        
            // Now delete the user
            $user->delete();
        
            DB::commit();
        
            return redirect(route('home'))->with('success', 'User Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            
            // Log the error
            Log::error('An error occurred while deleting user with ID ' . $user->id, ['exception' => $e]);
        
            return redirect(route('home'))->with('error', 'An error occurred while deleting the user.');
        };
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
                return redirect(route('home'))->with('success', 'HOD Role Assigned Successfully');
            }else {
                // If the user is not an HOD, update the user's role_id
                $user->role_id = $request->role_id;
                $user->save();
                $department = Department::where('department', $request->department)->first();
                // Update the department record with the new HOD
                $department->hod_id = $user->id;
                $department->save();
                return redirect(route('home'))->with('success', 'HOD Role Assigned Successfully');
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
                return redirect(route('home'))->with('success', 'Admin Assigned Successfully');
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
        return view('all-users', compact('users'));
    }

    public function getAllHods(){
        $hods = Department::whereNotNull('hod_id')->with('user')->get();
        return view('all-hods', compact('hods'));
    }

    public function getUsers()
    {
        $user = auth()->user();
        $sqlBuilder = User::select([
            'id',
            'first_name',
            'last_name',
            'staff_id',
            'department',
            'gender',
        ]);

        if ($user->role_id == 2) { // Assuming 2 is the role ID for HOD
            // Get the department where the user is the HOD
            $department = Department::where('hod_id', $user->id)->first();

            if ($department) {
                // Fetch all users in the HOD's department
                $sqlBuilder->where('department', $department->department);
            } else {
                // Handle the case where the HOD has no department
                return response()->json(['error' => 'You are not assigned to any department.'], 403);
            }
        } else {
            // Fetch all users excluding those with role_id = 4
            $sqlBuilder->where('role_id', '!=', 4);
        }

        $dt = new Datatables(new LaravelAdapter);
        $dt->query($sqlBuilder);
        return $dt->generate();
    }
}
