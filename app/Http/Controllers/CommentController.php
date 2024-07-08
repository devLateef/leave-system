<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDaysGiven = $startDate->diffInDays($endDate) + 1; // Include the start date
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
        }

        // Retrieving the associated leave and updating its status
        // $leave = Leave::find($request->leave_id);
        $leave = $new_comment->leave;
        if($leave){
            if($user->role_id == env('HOD')){
                $leave->hod_approval = 'Approved';
                $leave->save();
            }elseif($user->role_id == env('ADMIN')){
                $leave->final_approval = 'Approved';
                $leave->save();
            }else{
                $leave->hod_approval = 'Approved';
                $leave->final_approval = 'Approved';
                $leave->save();
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
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDaysGiven = $startDate->diffInDays($endDate) + 1; // Include the start date
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
            $new_comment->days_givem = $totalDaysGiven;
            $new_comment->save();
        }

        // Retrieving the associated leave and updating its status
        $leave = Leave::find($request->leave_id);
        // $leave = $new_comment->leave;
        if($leave){
            if($user->role_id == env('HOD')){
                $leave->hod_approval = 'Defered';
                $leave->save();
            }elseif($user->role_id == env('ADMIN')){
                $leave->final_approval = 'Defered';
                $leave->save();
            }else{
                $leave->hod_approval = 'Defered';
                $leave->final_approval = 'Defered';
                $leave->save();
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
        // $leave = $new_comment->leave;
        if($leave){
            if($user->role_id == env('HOD')){
                $leave->hod_approval = 'Declined';
                $leave->save();
            }elseif($user->role_id == env('ADMIN')){
                $leave->final_approval = 'Declined';
                $leave->save();
            }else{
                $leave->hod_approval = 'Declined';
                $leave->final_approval = 'Declined';
                $leave->save();
            };
        };
        // $leave->save();
        
        return redirect(route('home'))->with('success', 'Message saved successfully');
    }
}
