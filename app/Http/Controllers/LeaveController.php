<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationSubmitted;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

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
        $user = Auth::user();
        $this->authorize('create', Leave::class);
        return view('apply', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $hod = User::where('department', $user->department)->where('role_id', 2)->first();
        $superAdmin = User::where('role_id', 4)->first();
        $admin = User::where('role_id', 3)->first();
        if($admin && $hod){
            $recipients = [$superAdmin->email, $admin->email, $hod->email];
        }else{
            $recipients = [$superAdmin];
        }
        $leave_balance = $user->leave_balance;
        $request->validate([
            'start_date' => ['required', 'date', function($attribute, $value, $fail) {
                $date = SupportCarbon::parse($value);
                $dayOfWeek = $date->dayOfWeek;
        
                if ($dayOfWeek == SupportCarbon::SUNDAY || $dayOfWeek == SupportCarbon::SATURDAY) {
                    $fail('The start date cannot be a weekend.');
                }
        
                if ($date->isBefore(SupportCarbon::today())) {
                    $fail('The start date cannot be in the past.');
                }
            }],
            'end_date' => ['required', 'date', function($attribute, $value, $fail) use ($request) {
                $date = SupportCarbon::parse($value);
                $dayOfWeek = $date->dayOfWeek;
                $startDate = SupportCarbon::parse($request->start_date);
        
                if ($dayOfWeek == SupportCarbon::SUNDAY || $dayOfWeek == SupportCarbon::SATURDAY) {
                    $fail('The end date cannot be a weekend.');
                }
        
                if ($date->isBefore(SupportCarbon::today())) {
                    $fail('The end date cannot be in the past.');
                }
        
                if ($date->isBefore($startDate)) {
                    $fail('The end date cannot be before the start date.');
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
         $weekends = 0;
 
         // Count weekends within the range
         for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
             if ($date->isWeekend()) {
                 $weekends++;
             }
         }
 
         $totalDaysRequested -= $weekends;

         $applyingUser = User::find($user->id);
        if($totalDaysRequested <= $leave_balance){
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
            //Immediately removing the requested days from the user leave balance to enforce leave balance constraint
            $applyingUser->leave_balance -= $totalDaysRequested;
            $applyingUser->save();
            Mail::to($recipients)->send(new ApplicationSubmitted($new_leave, $recipients));
            return redirect()->route('home')->with('success', 'Leave Applied successfully.');
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
            $applyingUser->leave_balance -= $totalDaysRequested;
            $applyingUser->save();
            Mail::to($recipients)->send(new ApplicationSubmitted($new_leave, $recipients));
            return redirect()->route('home')->with('success', 'Leave Applied successfully.');
        }else{
            return redirect()->back()->with('message', __('Sorry: You have :leave_balance Available Leaves.', ['leave_balance' => $leave_balance]));
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

    public function showApprove(Leave $leave){
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
        return view('approve-form', compact('leave'));
    }

    public function showDefer(Leave $leave){
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
        return view('defer-form', compact('leave'));
    }

    public function showDecline(Leave $leave){
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
        return view('decline-form', compact('leave'));
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
        $user = Auth::user();
        $hod = User::where('department', $user->department)->where('role_id', 2)->first();
        $superAdmin = User::where('role_id', 4)->first();
        $admin = User::where('role_id', 3)->first();
        if($admin && $hod){
            $recipients = [$superAdmin->email, $admin->email, $hod->email];
        }else{
            $recipients = [$superAdmin];
        }
        $leave_balance = $user->leave_balance;

        $request->validate([
            'start_date' => ['required', 'date', function($attribute, $value, $fail) {
                $date = SupportCarbon::parse($value);
                $dayOfWeek = $date->dayOfWeek;
        
                if ($dayOfWeek == SupportCarbon::SUNDAY || $dayOfWeek == SupportCarbon::SATURDAY) {
                    $fail('The start date cannot be a weekend.');
                }
        
                if ($date->isBefore(SupportCarbon::today())) {
                    $fail('The start date cannot be in the past.');
                }
            }],
            'end_date' => ['required', 'date', function($attribute, $value, $fail) use ($request) {
                $date = SupportCarbon::parse($value);
                $dayOfWeek = $date->dayOfWeek;
                $startDate = SupportCarbon::parse($request->start_date);
        
                if ($dayOfWeek == SupportCarbon::SUNDAY || $dayOfWeek == SupportCarbon::SATURDAY) {
                    $fail('The end date cannot be a weekend.');
                }
        
                if ($date->isBefore(SupportCarbon::today())) {
                    $fail('The end date cannot be in the past.');
                }
        
                if ($date->isBefore($startDate)) {
                    $fail('The end date cannot be before the start date.');
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
        $weekends = 0;

        // Count weekends within the range
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekend()) {
                $weekends++;
            }
        }

        $totalDaysRequested -= $weekends;
        $applyingUser = User::find($leave->user_id);
        //Adding the existing days requested to leave balance before editing
        $applyingUser->leave_balance += $leave->total_days_requested;
        $applyingUser->save();
        if ($totalDaysRequested <= $leave_balance) {
            $leave->leave_type = $request->leave_type;
            $leave->start_date = $request->start_date;
            $leave->end_date = $request->end_date;
            $leave->total_days_requested = $totalDaysRequested;
            $leave->designation = $request->designation;
            $leave->standin_staff = $request->standin_staff;
            $leave->comment = $request->comment;
            $leave->user_id = Auth::user()->id;
            $leave->save();
            //Immediately removing the requested days from the user leave balance to enforce leave balance constraint
            $applyingUser = User::find($leave->user_id);
            $applyingUser->leave_balance -= $leave->total_days_requested;
            $applyingUser->save();
            Mail::to($recipients)->send(new ApplicationSubmitted($leave, $recipients));
            return redirect(route('home'))->with('success', 'Leave Updated Successfully');
        } else {
            return redirect()->back()->with('message', __('Sorry: You have :leave_balance Available Leaves.', ['leave_balance' => $leave_balance]));
        }
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

    public function getLeaveApplications(Request $request)
    {
        $user = auth()->user();
        $superAdmin = config('roles.SUPER_ADMIN');
        $admin = config('roles.ADMIN');
        $hod = config('roles.HOD');
    
        // Base query with join
        $query = Leave::select([
                'leaves.id',
                'leaves.leave_type',
                'leaves.start_date',
                'leaves.end_date',
                'leaves.hod_approval',
                'leaves.final_approval',
                'users.first_name',
                'users.last_name',
                'users.role_id',
            ])
            ->join('users', 'leaves.user_id', '=', 'users.id');
    
        // Modify query based on user role
        if ($user->role_id == $superAdmin) {
            // SuperAdmin can see all leave applications
        } elseif ($user->role_id == $admin) {
            // Admin can see leave applications excluding role_id = 4
            $query->where('users.role_id', '!=', 4);
        } elseif ($user->role_id == $hod) {
            // HOD can see leave applications of their department
            $query->whereHas('user', function($q) use ($user) {
                $q->where('department', $user->department);
            });
        } else {
            // Other users can see only their own leave applications
            $query->where('user_id', $user->id);
        }
    
        // Ensure data is ordered by created_at in descending order
        $query->orderBy('leaves.created_at', 'desc');
    
        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->input('search')['value'])) {
                    $searchValue = $request->input('search')['value'];
    
                    // Applying search filter
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('users.first_name', 'like', '%' . $searchValue . '%')
                            ->orWhere('users.last_name', 'like', '%' . $searchValue . '%')
                            ->orWhere('leaves.leave_type', 'like', '%' . $searchValue . '%');
                    });
                }
            })
            ->addIndexColumn() // This automatically handles the numbering in ascending order
            ->addColumn('full_name', function($row) {
                return $row->first_name . ' ' . $row->last_name;
            })
            ->addColumn('hod_approval', function($row) {
                $class = $row->hod_approval == 'Approved' ? 'text-success' : ($row->hod_approval == 'Defered' ? 'text-info' : ($row->hod_approval == 'Pending' ? 'text-warning' : 'text-danger'));
                return '<span class="fw-bold '.$class.'">'.$row->hod_approval.'</span>';
            })
            ->addColumn('final_approval', function($row) {
                $class = $row->final_approval == 'Approved' ? 'text-success' : ($row->final_approval == 'Defered' ? 'text-info' : ($row->final_approval == 'Pending' ? 'text-warning' : 'text-danger'));
                return '<span class="fw-bold '.$class.'">'.$row->final_approval.'</span>';
            })
            ->addColumn('action', function($row) use ($user, $superAdmin, $admin, $hod) {
                $buttons = '';
    
                if ($user->role_id == $superAdmin || $user->role_id == $admin || $user->role_id == $hod) {
                    $buttons .= '<a href="'.route('leaves.show', $row->id).'"><button class="btn btn-primary m-2">Show Details</button></a>';
                } elseif ($row->hod_approval == 'Pending' && $row->final_approval == 'Pending') {
                    $buttons .= '<a href="'.route('leaves.show', $row->id).'"><button class="btn btn-primary m-1">Show</button></a>';
                    $buttons .= '<a href="'.route('leaves.edit', $row->id).'"><button class="btn btn-danger m-1">Edit</button></a>';
                } else {
                    $buttons .= '<a href="'.route('leaves.show', $row->id).'"><button class="btn btn-primary m-1">Show</button></a>';
                }
    
                return $buttons;
            })
            ->rawColumns(['full_name', 'hod_approval', 'final_approval', 'action'])
            ->make(true);
        }
}
