<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_type',
        'start_date',
        'end_date',
        'designation',
        'standin_staff',
        'comment',
        'total_days_requested',
        'hod_approval',
        'final_approval'
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
