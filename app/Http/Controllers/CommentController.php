<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationReviewed;
use App\Models\Comment;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $user = Auth::user();
        // Calculate total days requested
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $totalDaysGiven = $startDate->diffInDays($endDate) + 1; // Include the start date
        $weekends = 0;

        // Count weekends within the range
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekend()) {
                $weekends++;
            }
        }

        $totalDaysGiven -= $weekends;

        $existing_comment = Comment::where('user_id', $user->id)
        ->where('leave_id', $request->leave_id)->first();

        if ($existing_comment) {
            $total_days_requested = $existing_comment->leave->total_days_requested;
            $leaveOwner = User::find($existing_comment->leave->user_id);
            $leaveOwner->leave_balance += $total_days_requested;
            $leaveOwner->save();
            $existing_comment->start_date = $request->start_date;
            $existing_comment->end_date = $request->end_date;
            $existing_comment->message = $request->message;
            // Get the user who applied for the leave
            $appliedUser = User::find($existing_comment->leave->user_id);
            if(isset($existing_comment->days_given)){
                // Add the previous days given back to the user's leave balance
                $appliedUser->leave_balance += $existing_comment->days_given;
                $appliedUser->save();
                $existing_comment->days_given = $totalDaysGiven;
            }else{
                $existing_comment->days_given = $totalDaysGiven;
            }
            $existing_comment->save();
        }else{
            $new_comment = new Comment();
            $new_comment->start_date = $request->start_date;
            $new_comment->end_date = $request->end_date;
            $new_comment->message = $request->message;
            $new_comment->leave_id = $request->leave_id;
            $new_comment->user_id = Auth::user()->id;
            $new_comment->days_given = $totalDaysGiven;
            $new_comment->save();
            $total_days_requested = $new_comment->leave->total_days_requested;
            $leaveOwner = User::find($new_comment->leave->user_id);
            $leaveOwner->leave_balance += $total_days_requested;
            $leaveOwner->save();
            
        }

        // Retrieving the associated leave and updating its status
        $leave = Leave::find($request->leave_id);
        $leaveOwner = User::find($leave->user_id);
        $recipient = [$leaveOwner->email];
        // $leave = $new_comment->leave;
        if($leave){
            if($user->role_id == config('roles.HOD')){
                $leave->hod_approval = 'Approved';
                $leave->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            }elseif($user->role_id == config('roles.ADMIN')){
                $leave->final_approval = 'Approved';
                $leave->save();
                $appliedUser = User::find($leave->user_id);
                $appliedUser->leave_balance -= $totalDaysGiven;
                $appliedUser->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            }else{
                $leave->hod_approval = 'Approved';
                $leave->final_approval = 'Approved';
                $leave->save();
                $appliedUser = User::find($leave->user_id);
                $appliedUser->leave_balance -= $totalDaysGiven;
                $appliedUser->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            };
        };
        // $leave->save();
        
        return redirect(route('home'))->with('success', 'Message saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }

    public function storeDefer(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $user = Auth::user();
        // Calculate total days requested
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $totalDaysGiven = $startDate->diffInDays($endDate) + 1; // Include the start date
        $weekends = 0;

        // Count weekends within the range
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekend()) {
                $weekends++;
            }
        }

        $totalDaysGiven -= $weekends;

        $existing_comment = Comment::where('user_id', $user->id)
        ->where('leave_id', $request->leave_id)->first();

        if ($existing_comment) {
            $existing_comment->start_date = $request->start_date;
            $existing_comment->end_date = $request->end_date;
            $existing_comment->message = $request->message;
            $existing_comment->days_given = $totalDaysGiven;
            $existing_comment->save();
        }else{
            $new_comment = new Comment();
            $new_comment->start_date = $request->start_date;
            $new_comment->end_date = $request->end_date;
            $new_comment->message = $request->message;
            $new_comment->leave_id = $request->leave_id;
            $new_comment->user_id = Auth::user()->id;
            $new_comment->days_given = $totalDaysGiven;
            $new_comment->save();
            $total_days_requested = $new_comment->leave->total_days_requested;
            $leaveOwner = User::find($new_comment->leave->user_id);
            $leaveOwner->leave_balance += $total_days_requested;
            $leaveOwner->save();
        }

        // Retrieving the associated leave and updating its status
        $leave = Leave::find($request->leave_id);
        $leaveOwner = User::find($leave->user_id);
        $recipient = [$leaveOwner->email];
        // $leave = $new_comment->leave;
        if($leave){
            if($user->role_id == env('HOD')){
                $leave->hod_approval = 'Defered';
                $leave->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            }elseif($user->role_id == env('ADMIN')){
                $leave->final_approval = 'Defered';
                $leave->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            }else{
                $leave->hod_approval = 'Defered';
                $leave->final_approval = 'Defered';
                $leave->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            };
        };
        // $leave->save();
        
        return redirect(route('home'))->with('success', 'Message saved successfully');
    }

    public function storeDecline(Request $request){
        $user = Auth::user();
        $existing_comment = Comment::where('user_id', $user->id)
        ->where('leave_id', $request->leave_id)->first();

        if ($existing_comment) {
            $existing_comment->message = $request->message;
            $existing_comment->save();
        }else{
            $new_comment = new Comment();
            $new_comment->message = $request->message;
            $new_comment->leave_id = $request->leave_id;
            $new_comment->user_id = Auth::user()->id;
            $new_comment->save();
        }

        // Retrieving the associated leave and updating its status
        $leave = Leave::find($request->leave_id);
        $leaveOwner = User::find($leave->user_id);
        $recipient = [$leaveOwner->email];
        // $leave = $new_comment->leave;
        if($leave){
            if($user->role_id == env('HOD')){
                $leave->hod_approval = 'Declined';
                $leave->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            }elseif($user->role_id == env('ADMIN')){
                $leave->final_approval = 'Declined';
                $leave->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            }else{
                $leave->hod_approval = 'Declined';
                $leave->final_approval = 'Declined';
                $leave->save();
                Mail::to($recipient)->send(new ApplicationReviewed($leave, $recipient));
            };
        };
        // $leave->save();
        
        return redirect(route('home'))->with('success', 'Message saved successfully');
    }
}
